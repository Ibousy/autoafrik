<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Client;
use App\Models\Maintenance;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    private function tid(): int
    {
        return request()->user()->company_id;
    }

    public function index(Request $request): JsonResponse
    {
        $q = Maintenance::with(['vehicle:id,make,model,registration', 'client:id,name,phone'])
            ->orderBy('scheduled_at');

        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }
        if ($type = $request->input('type')) {
            $q->where('type', $type);
        }

        $items = $q->get()->map(fn($m) => [
            'id'           => $m->id,
            'type'         => $m->type,
            'type_label'   => Maintenance::$types[$m->type]['label'] ?? $m->type,
            'type_icon'    => Maintenance::$types[$m->type]['icon']  ?? 'fa-wrench',
            'type_color'   => Maintenance::$types[$m->type]['color'] ?? '#64748B',
            'description'  => $m->description,
            'scheduled_at' => $m->scheduled_at?->format('Y-m-d'),
            'completed_at' => $m->completed_at?->format('Y-m-d'),
            'mileage'      => $m->mileage,
            'cost'         => $m->cost,
            'status'       => $m->status,
            'status_label' => Maintenance::$statuses[$m->status]['label'] ?? $m->status,
            'status_color' => Maintenance::$statuses[$m->status]['color'] ?? '#64748B',
            'status_bg'    => Maintenance::$statuses[$m->status]['bg']    ?? '#F1F5F9',
            'notes'        => $m->notes,
            'vehicle'      => $m->vehicle ? [
                'id'           => $m->vehicle->id,
                'label'        => $m->vehicle->make . ' ' . $m->vehicle->model,
                'registration' => $m->vehicle->registration,
            ] : null,
            'client'       => $m->client ? [
                'id'    => $m->client->id,
                'name'  => $m->client->name,
                'phone' => $m->client->phone,
            ] : null,
        ]);

        $stats = [
            'total'    => Maintenance::count(),
            'planifie' => Maintenance::where('status', 'planifie')->count(),
            'en_cours' => Maintenance::where('status', 'en_cours')->count(),
            'termine'  => Maintenance::where('status', 'termine')
                            ->whereMonth('completed_at', now()->month)->count(),
        ];

        return response()->json(['maintenances' => $items, 'stats' => $stats]);
    }

    public function store(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $data = $request->validate([
            'type'         => 'required|in:vidange,revision,controle_technique,pneumatiques,freins,batterie,courroie,filtre,climatisation,geometrie,autre',
            'description'  => 'nullable|string|max:255',
            'vehicle_id'   => 'nullable|integer',
            'client_id'    => 'nullable|integer',
            'scheduled_at' => 'required|date',
            'mileage'      => 'nullable|integer|min:0',
            'cost'         => 'nullable|numeric|min:0',
            'status'       => 'nullable|in:planifie,en_cours,termine,annule',
            'notes'        => 'nullable|string|max:1000',
        ]);

        $data['company_id'] = $me->company_id;
        $data['status']     = $data['status'] ?? 'planifie';

        $m = Maintenance::create($data);

        AppNotification::notifyAll(
            $me->company_id,
            'Entretien planifié',
            Maintenance::$types[$m->type]['label'] . ' planifié pour le ' . $m->scheduled_at->format('d/m/Y'),
            'info', 'tools', 'entretien'
        );

        return response()->json(['maintenance' => $m->load(['vehicle:id,make,model,registration', 'client:id,name,phone'])], 201);
    }

    public function update(Request $request, Maintenance $maintenance): JsonResponse
    {
        abort_if($maintenance->company_id !== $this->tid(), 403);

        /** @var \App\Models\User $me */
        $me = $request->user();

        $data = $request->validate([
            'type'         => 'sometimes|in:vidange,revision,controle_technique,pneumatiques,freins,batterie,courroie,filtre,climatisation,geometrie,autre',
            'description'  => 'nullable|string|max:255',
            'vehicle_id'   => 'nullable|integer',
            'client_id'    => 'nullable|integer',
            'scheduled_at' => 'sometimes|date',
            'completed_at' => 'nullable|date',
            'mileage'      => 'nullable|integer|min:0',
            'cost'         => 'nullable|numeric|min:0',
            'status'       => 'sometimes|in:planifie,en_cours,termine,annule',
            'notes'        => 'nullable|string|max:1000',
        ]);

        $wasNotDone = $maintenance->status !== 'termine';
        $maintenance->update($data);

        if ($wasNotDone && $maintenance->status === 'termine') {
            if (! $data['completed_at'] ?? null) {
                $maintenance->update(['completed_at' => now()->toDateString()]);
            }
            AppNotification::notifyAll(
                $me->company_id,
                'Entretien terminé',
                Maintenance::$types[$maintenance->type]['label'] . ' marqué comme terminé',
                'success', 'check-circle', 'entretien'
            );
        }

        return response()->json(['maintenance' => $maintenance->fresh(['vehicle:id,make,model,registration', 'client:id,name,phone'])]);
    }

    public function destroy(Maintenance $maintenance): JsonResponse
    {
        abort_if($maintenance->company_id !== $this->tid(), 403);
        $maintenance->delete();
        return response()->json(['ok' => true]);
    }

    public function vehiclesList(): JsonResponse
    {
        $vehicles = Vehicle::orderBy('make')
            ->get(['id', 'make', 'model', 'registration']);
        return response()->json(['vehicles' => $vehicles]);
    }

    public function clientsList(): JsonResponse
    {
        $clients = Client::orderBy('name')
            ->get(['id', 'name', 'phone']);
        return response()->json(['clients' => $clients]);
    }
}
