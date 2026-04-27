<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    private static array $segmentViewMap = [
        'clients'      => 'clients',
        'vehicles'     => 'vehicules',
        'repairs'      => 'reparations',
        'rentals'      => 'locations',
        'stock'        => 'stock',
        'employees'    => 'employes',
        'transactions' => 'comptabilite',
        'reports'      => 'rapports',
        'agents'       => 'equipe',
        'company'      => 'parametres',
        'plans'        => 'parametres',
    ];

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Non authentifié.'], 401);
        }

        // Fast path: role matches
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Fallback: owner granted this view via custom permissions
        if (!empty($user->permissions)) {
            $segment = $request->segment(2);
            $viewKey = self::$segmentViewMap[$segment] ?? null;
            if ($viewKey && $user->canView($viewKey)) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Accès refusé. Votre rôle ne permet pas cette action.'], 403);
    }
}
