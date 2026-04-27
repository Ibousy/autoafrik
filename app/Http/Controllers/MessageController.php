<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Message;
use App\Models\Rental;
use App\Models\Repair;
use App\Models\StockItem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // ── List messages — broadcast OR DM conversation
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me       = $request->user();
        $toUserId = $request->integer('to_user_id', 0);

        $query = Message::where('company_id', $me->company_id)
            ->where('is_bot', false)
            ->with(['fromUser:id,name,role']);

        if ($toUserId) {
            // DM: messages between me and toUser (both directions)
            $query->where(function ($q) use ($me, $toUserId) {
                $q->where(fn ($q2) => $q2->where('from_user_id', $me->id)->where('to_user_id', $toUserId))
                  ->orWhere(fn ($q2) => $q2->where('from_user_id', $toUserId)->where('to_user_id', $me->id));
            });
        } else {
            // Broadcast channel
            $query->where('is_broadcast', true);
        }

        $messages = $query->latest()->limit(50)->get()
            ->reverse()->values()
            ->map(fn ($m) => [
                'id'        => $m->id,
                'from'      => $m->fromUser
                    ? ['id' => $m->fromUser->id, 'name' => $m->fromUser->name, 'role' => $m->fromUser->role]
                    : null,
                'mine'      => $m->from_user_id === $me->id,
                'content'   => $m->content,
                'file_url'  => $m->file_url,
                'file_name' => $m->file_name,
                'file_mime' => $m->file_mime,
                'ago'       => $m->created_at->format('H:i'),
            ]);

        // Mark incoming messages as read
        if ($toUserId) {
            Message::where('company_id', $me->company_id)
                ->where('is_bot', false)
                ->where('from_user_id', $toUserId)
                ->where('to_user_id', $me->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        } else {
            Message::where('company_id', $me->company_id)
                ->where('is_bot', false)
                ->where('is_broadcast', true)
                ->where('from_user_id', '!=', $me->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return response()->json(['messages' => $messages]);
    }

    // ── Send a message (broadcast OR DM)
    public function store(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $data = $request->validate([
            'content'    => 'required|string|max:2000',
            'to_user_id' => 'nullable|integer|exists:users,id',
        ]);

        $isDm = !empty($data['to_user_id']);

        $msg = Message::create([
            'company_id'   => $me->company_id,
            'from_user_id' => $me->id,
            'to_user_id'   => $isDm ? $data['to_user_id'] : null,
            'is_broadcast' => !$isDm,
            'content'      => $data['content'],
        ]);

        return response()->json([
            'message' => 'Envoyé.',
            'msg'     => [
                'id'      => $msg->id,
                'mine'    => true,
                'from'    => ['id' => $me->id, 'name' => $me->name, 'role' => $me->role],
                'content' => $msg->content,
                'ago'     => $msg->created_at->format('H:i'),
            ],
        ], 201);
    }

    // ── Upload a file (broadcast OR DM)
    public function upload(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $request->validate(['file' => 'required|file|max:10240']);

        $toUserId = $request->integer('to_user_id', 0);
        $isDm     = $toUserId > 0;

        $file = $request->file('file');
        $path = $file->store("chat/{$me->company_id}", 'public');

        $msg = Message::create([
            'company_id'   => $me->company_id,
            'from_user_id' => $me->id,
            'to_user_id'   => $isDm ? $toUserId : null,
            'is_broadcast' => !$isDm,
            'file_path'    => $path,
            'file_name'    => $file->getClientOriginalName(),
            'file_mime'    => $file->getMimeType(),
        ]);

        return response()->json([
            'message' => 'Fichier envoyé.',
            'msg' => [
                'id'        => $msg->id,
                'mine'      => true,
                'from'      => ['id' => $me->id, 'name' => $me->name, 'role' => $me->role],
                'file_url'  => asset('storage/' . $path),
                'file_name' => $file->getClientOriginalName(),
                'file_mime' => $file->getMimeType(),
                'ago'       => $msg->created_at->format('H:i'),
            ],
        ], 201);
    }

    // ── AfricaERP Bot
    public function bot(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $data  = $request->validate(['message' => 'required|string|max:500']);
        $input = mb_strtolower(trim($data['message']));

        Message::create([
            'company_id'   => $me->company_id,
            'from_user_id' => $me->id,
            'is_bot'       => true,
            'content'      => $data['message'],
        ]);

        $reply = $this->buildBotReply($input, $me);

        Message::create([
            'company_id' => $me->company_id,
            'is_bot'     => true,
            'content'    => $reply,
        ]);

        return response()->json(['reply' => $reply]);
    }

    // ── Bot conversation history
    public function botHistory(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $msgs = Message::where('company_id', $me->company_id)
            ->where('is_bot', true)
            ->latest()->limit(40)->get()
            ->reverse()->values()
            ->map(fn ($m) => [
                'mine'    => !is_null($m->from_user_id),
                'content' => $m->content,
                'ago'     => $m->created_at->format('H:i'),
            ]);

        return response()->json(['messages' => $msgs]);
    }

    // ── Bot brain
    private function buildBotReply(string $input, User $me): string
    {
        $cid = $me->company_id;

        if (preg_match('/^(bonjour|salut|hello|hi|bonsoir|hey)/i', $input)) {
            $h     = (int) now()->format('H');
            $greet = $h < 12 ? 'Bonjour' : ($h < 18 ? 'Bonne après-midi' : 'Bonsoir');
            return "{$greet} {$me->name} ! Je suis **AfricaERP**, votre assistant. Je peux vous informer sur les réparations, locations, clients, stock et finances. Comment puis-je vous aider ?";
        }

        if (str_contains($input, 'répara') || str_contains($input, 'repara') || str_contains($input, 'répar')) {
            $pending    = Repair::where('company_id', $cid)->where('status', 'pending')->count();
            $inProgress = Repair::where('company_id', $cid)->where('status', 'in_progress')->count();
            $done       = Repair::where('company_id', $cid)->where('status', 'done')->whereMonth('completed_at', now()->month)->count();
            return "🔧 **Réparations du garage :**\n• En attente : **{$pending}**\n• En cours : **{$inProgress}**\n• Terminées ce mois : **{$done}**";
        }

        if (str_contains($input, 'location') || str_contains($input, 'locat') || str_contains($input, 'réservat')) {
            $active    = Rental::where('company_id', $cid)->where('status', 'active')->count();
            $completed = Rental::where('company_id', $cid)->where('status', 'completed')->whereMonth('end_date', now()->month)->count();
            $revenue   = Rental::where('company_id', $cid)->where('payment_status', 'paid')->whereMonth('start_date', now()->month)->sum('total_price');
            return "🚗 **Locations :**\n• En cours : **{$active}**\n• Terminées ce mois : **{$completed}**\n• Revenus locations (mois) : **" . number_format($revenue, 0, ',', ' ') . " FCFA**";
        }

        if (str_contains($input, 'client')) {
            $total   = Client::where('company_id', $cid)->count();
            $newThis = Client::where('company_id', $cid)->whereMonth('created_at', now()->month)->count();
            return "👥 **Clients :**\n• Total : **{$total}**\n• Nouveaux ce mois : **{$newThis}**";
        }

        if (str_contains($input, 'véhicul') || str_contains($input, 'vehicul') || str_contains($input, 'voiture')) {
            $available = Vehicle::where('company_id', $cid)->where('status', 'available')->count();
            $rented    = Vehicle::where('company_id', $cid)->where('status', 'rented')->count();
            $inRepair  = Vehicle::where('company_id', $cid)->whereIn('status', ['repair', 'maintenance'])->count();
            $total     = Vehicle::where('company_id', $cid)->count();
            return "🚙 **Parc véhicules ({$total}) :**\n• Disponibles : **{$available}**\n• En location : **{$rented}**\n• En réparation/maintenance : **{$inRepair}**";
        }

        if (str_contains($input, 'stock') || str_contains($input, 'pièce') || str_contains($input, 'piece')) {
            $total    = StockItem::where('company_id', $cid)->count();
            $low      = StockItem::where('company_id', $cid)->whereColumn('quantity', '<=', 'min_quantity')->count();
            $critical = StockItem::where('company_id', $cid)->where('quantity', 0)->count();
            $txt = "📦 **Stock ({$total} références) :**\n• Stock faible : **{$low}**\n• Rupture : **{$critical}**";
            if ($low > 0) $txt .= "\n⚠️ Pensez à réapprovisionner vos pièces en stock faible.";
            return $txt;
        }

        if (str_contains($input, 'revenu') || str_contains($input, 'chiffre') || str_contains($input, 'finance') || str_contains($input, 'argent') || str_contains($input, 'bénéfice') || str_contains($input, 'benefice')) {
            $revenue = Transaction::where('company_id', $cid)->where('type', 'revenue')->whereMonth('date', now()->month)->sum('amount');
            $expense = Transaction::where('company_id', $cid)->where('type', 'expense')->whereMonth('date', now()->month)->sum('amount');
            $profit  = $revenue - $expense;
            $sign    = $profit >= 0 ? '+' : '';
            return "💰 **Finances — " . now()->translatedFormat('F Y') . " :**\n• Revenus : **" . number_format($revenue, 0, ',', ' ') . " FCFA**\n• Dépenses : **" . number_format($expense, 0, ',', ' ') . " FCFA**\n• Bénéfice net : **{$sign}" . number_format($profit, 0, ',', ' ') . " FCFA**";
        }

        if (str_contains($input, 'employ') || str_contains($input, 'mécanic') || str_contains($input, 'mechanic') || str_contains($input, 'équipe') || str_contains($input, 'equipe')) {
            $active = Employee::where('company_id', $cid)->where('status', 'active')->count();
            $total  = Employee::where('company_id', $cid)->count();
            return "👔 **Équipe : {$total} employés ({$active} actifs)**\nVous pouvez voir les détails dans l'onglet **Employés**.";
        }

        if (str_contains($input, 'aide') || str_contains($input, 'help') || str_contains($input, 'que') || str_contains($input, 'comment') || str_contains($input, 'quoi')) {
            return "🤖 Je peux vous renseigner sur :\n• **Réparations** — statut, en cours\n• **Locations** — actives, revenus\n• **Clients** — total, nouveaux\n• **Véhicules** — disponibilité\n• **Stock** — niveaux, ruptures\n• **Finances** — revenus, dépenses, bénéfice\n• **Équipe** — employés\n\nPosez-moi une question !";
        }

        return "Je n'ai pas compris votre question. Essayez de me demander des informations sur les **réparations**, **locations**, **clients**, **véhicules**, **stock** ou **finances**. Tapez **aide** pour voir ce que je sais faire.";
    }
}
