<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $clients = Client::query()
            ->when($request->search, fn ($q, $s) =>
                $q->where('first_name', 'like', "%$s%")
                  ->orWhere('last_name',  'like', "%$s%")
                  ->orWhere('phone',       'like', "%$s%")
                  ->orWhere('email',       'like', "%$s%")
            )
            ->when($request->type, fn ($q, $t) => $q->where('type', $t))
            ->withCount(['repairs', 'rentals'])
            ->latest()
            ->paginate(15);

        return response()->json($clients);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $client = Client::create(array_merge($request->validated(), ['company_id' => auth()->user()->company_id]));

        return response()->json([
            'message' => 'Client créé avec succès.',
            'client'  => $client,
        ], 201);
    }

    public function show(Client $client): JsonResponse
    {
        $client->loadCount(['repairs', 'rentals']);
        $client->load(['repairs.vehicle', 'rentals.vehicle']);
        $client->total_spent = $client->total_spent;

        return response()->json($client);
    }

    public function update(StoreClientRequest $request, Client $client): JsonResponse
    {
        $client->update($request->validated());

        return response()->json([
            'message' => 'Client mis à jour.',
            'client'  => $client->fresh(),
        ]);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();
        return response()->json(['message' => 'Client supprimé.']);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total'    => Client::count(),
            'new_this_month' => Client::whereMonth('created_at', now()->month)->count(),
            'vip'      => Client::withSum([
                'repairs as repairs_total' => fn ($q) => $q->where('payment_status', 'paid'),
            ], 'total_cost')
            ->withSum([
                'rentals as rentals_total' => fn ($q) => $q->where('payment_status', 'paid'),
            ], 'total_price')
            ->get()
            ->filter(fn ($c) => ($c->repairs_total + $c->rentals_total) > 500000)
            ->count(),
        ]);
    }
}
