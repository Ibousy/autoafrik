<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentalRequest;
use App\Models\AppNotification;
use App\Models\Rental;
use App\Models\Transaction;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $rentals = Rental::with(['vehicle', 'client'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->payment_status, fn ($q, $s) => $q->where('payment_status', $s))
            ->when($request->search, fn ($q, $s) =>
                $q->whereHas('client', fn ($c) =>
                    $c->where('first_name', 'like', "%$s%")->orWhere('last_name', 'like', "%$s%")
                )->orWhereHas('vehicle', fn ($v) =>
                    $v->where('brand', 'like', "%$s%")->orWhere('registration', 'like', "%$s%")
                )
            )
            ->latest()
            ->paginate(15);

        return response()->json($rentals);
    }

    public function store(StoreRentalRequest $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        if ($vehicle->status === 'rented') {
            return response()->json(['message' => 'Ce véhicule est déjà en location.'], 422);
        }

        $rental = Rental::create(array_merge($request->validated(), ['company_id' => $me->company_id]));

        // Auto-generate transaction if paid
        if ($rental->payment_status === 'paid') {
            Transaction::create([
                'company_id'     => $me->company_id,
                'type'           => 'revenue',
                'category'       => 'location',
                'amount'         => $rental->total_price,
                'description'    => "Location — {$rental->vehicle->full_name} · {$rental->client->full_name}",
                'reference_type' => Rental::class,
                'reference_id'   => $rental->id,
                'date'           => now()->toDateString(),
            ]);
        }

        $rental->loadMissing(['vehicle', 'client']);
        AppNotification::notifyAll(
            $me->company_id,
            "Nouvelle location créée",
            ($rental->vehicle->full_name ?? 'Véhicule') . " → " . ($rental->client->full_name ?? 'Client'),
            'info', 'car', 'locations'
        );

        return response()->json([
            'message' => 'Réservation créée avec succès.',
            'rental'  => $rental->load(['vehicle', 'client']),
        ], 201);
    }

    public function show(Rental $rental): JsonResponse
    {
        $rental->load(['vehicle', 'client']);
        return response()->json($rental);
    }

    public function update(StoreRentalRequest $request, Rental $rental): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $wasNotPaid      = $rental->payment_status !== 'paid';
        $wasNotCompleted = $rental->status !== 'completed';
        $rental->update($request->validated());

        // Create transaction when payment confirmed
        if ($wasNotPaid && $rental->payment_status === 'paid') {
            Transaction::firstOrCreate(
                ['reference_type' => Rental::class, 'reference_id' => $rental->id],
                [
                    'company_id'  => $me->company_id,
                    'type'        => 'revenue',
                    'category'    => 'location',
                    'amount'      => $rental->total_price,
                    'description' => "Location — {$rental->vehicle->full_name} · {$rental->client->full_name}",
                    'date'        => now()->toDateString(),
                ]
            );
        }

        if ($wasNotCompleted && $rental->status === 'completed') {
            $rental->loadMissing(['vehicle', 'client']);
            AppNotification::notifyAll(
                $me->company_id,
                "Location terminée",
                ($rental->vehicle->full_name ?? 'Véhicule') . " restituée",
                'success', 'flag-checkered', 'locations'
            );
        }

        return response()->json([
            'message' => 'Location mise à jour.',
            'rental'  => $rental->fresh()->load(['vehicle', 'client']),
        ]);
    }

    public function destroy(Rental $rental): JsonResponse
    {
        $rental->update(['status' => 'cancelled']);
        return response()->json(['message' => 'Location annulée.']);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'active'          => Rental::where('status', 'active')->count(),
            'completed_month' => Rental::where('status', 'completed')
                ->whereMonth('end_date', now()->month)->count(),
            'revenue_month'   => Rental::where('payment_status', 'paid')
                ->whereMonth('start_date', now()->month)->sum('total_price'),
            'available'       => Vehicle::where('type', 'rental')
                ->where('status', 'available')->count(),
        ]);
    }
}
