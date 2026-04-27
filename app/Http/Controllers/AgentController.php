<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    private static array $allViews = [
        'dashboard', 'clients', 'vehicules', 'reparations',
        'locations', 'stock', 'employes', 'comptabilite', 'rapports', 'equipe', 'parametres',
    ];

    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $agents = User::where('company_id', $me->company_id)
            ->orderByRaw("FIELD(role,'owner','admin','manager','accountant','receptionist','mechanic')")
            ->get()
            ->map(fn ($u) => [
                'id'          => $u->id,
                'name'        => $u->name,
                'email'       => $u->email,
                'phone'       => $u->phone,
                'role'        => $u->role,
                'role_info'   => $u->role_info,
                'is_active'   => $u->is_active,
                'permissions' => $u->allowed_views,
                'initials'    => strtoupper(mb_substr($u->name, 0, 1)) . strtoupper(mb_substr(strstr($u->name, ' ') ?: ' ', 1, 1)),
                'created_at'  => $u->created_at?->format('d/m/Y'),
            ]);

        $company = $me->company;

        return response()->json([
            'agents'     => $agents,
            'total'      => $agents->count(),
            'max_agents' => $company?->max_agents,
            'can_add'    => $company?->canAddAgent(),
            'plan'       => $company?->plan,
            'plan_info'  => $company?->plan_info,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me      = $request->user();
        $company = $me->company;

        if (!$company?->canAddAgent()) {
            return response()->json([
                'message' => "Limite atteinte ({$company->max_agents} agents). Passez à un plan supérieur.",
            ], 422);
        }

        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'nullable|string|max:20',
            'role'          => 'required|in:admin,manager,mechanic,accountant,receptionist',
            'password'      => 'required|string|min:8',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', self::$allViews),
        ]);

        $permissions = $data['permissions'] ?? null;

        if ($permissions !== null && !in_array('dashboard', $permissions)) {
            array_unshift($permissions, 'dashboard');
        }

        $user = User::create([
            'company_id'  => $company->id,
            'name'        => $data['name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'] ?? null,
            'role'        => $data['role'],
            'password'    => Hash::make($data['password']),
            'is_active'   => true,
            'permissions' => $permissions,
        ]);

        return response()->json(['message' => 'Agent créé avec succès.', 'agent' => $user], 201);
    }

    public function update(Request $request, int $agent): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me   = $request->user();
        $user = User::where('id', $agent)->where('company_id', $me->company_id)->firstOrFail();

        $data = $request->validate([
            'name'          => 'sometimes|required|string|max:100',
            'phone'         => 'nullable|string|max:20',
            'role'          => 'sometimes|required|in:admin,manager,mechanic,accountant,receptionist',
            'is_active'     => 'sometimes|boolean',
            'password'      => 'nullable|string|min:8',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', self::$allViews),
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (isset($data['permissions']) && !in_array('dashboard', $data['permissions'])) {
            array_unshift($data['permissions'], 'dashboard');
        }

        $user->update($data);

        return response()->json(['message' => 'Agent mis à jour.', 'agent' => $user->fresh()]);
    }

    public function destroy(Request $request, int $agent): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me   = $request->user();
        $user = User::where('id', $agent)->where('company_id', $me->company_id)->firstOrFail();

        if ($user->role === 'owner') {
            return response()->json(['message' => 'Impossible de supprimer le propriétaire.'], 422);
        }

        $user->delete();
        return response()->json(['message' => 'Agent supprimé.']);
    }

    // ── Lightweight team list for messaging (all authenticated users)
    public function teamMembers(Request $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $members = User::where('company_id', $me->company_id)
            ->where('id', '!=', $me->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'role']);

        return response()->json(['members' => $members]);
    }
}
