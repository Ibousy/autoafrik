<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $vehicles = Vehicle::query()
            ->when($request->type,   fn ($q, $t) => $q->where('type', $t))
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->search, fn ($q, $s) =>
                $q->where('brand', 'like', "%$s%")
                  ->orWhere('model', 'like', "%$s%")
                  ->orWhere('registration', 'like', "%$s%")
            )
            ->withCount(['repairs', 'rentals'])
            ->latest()
            ->paginate(18);

        return response()->json($vehicles);
    }

    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $vehicle = Vehicle::create(array_merge($request->validated(), ['company_id' => auth()->user()->company_id]));

        return response()->json([
            'message' => 'Véhicule ajouté avec succès.',
            'vehicle' => $vehicle,
        ], 201);
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        $vehicle->load(['repairs.client', 'rentals.client']);
        $vehicle->load(['repairs' => fn ($q) => $q->latest()->limit(5)]);
        return response()->json($vehicle);
    }

    public function update(StoreVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $vehicle->update($request->validated());

        return response()->json([
            'message' => 'Véhicule mis à jour.',
            'vehicle' => $vehicle->fresh(),
        ]);
    }

    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();
        return response()->json(['message' => 'Véhicule supprimé.']);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total'       => Vehicle::count(),
            'available'   => Vehicle::where('status', 'available')->count(),
            'rented'      => Vehicle::where('status', 'rented')->count(),
            'maintenance' => Vehicle::where('status', 'maintenance')->count(),
            'repair'      => Vehicle::where('status', 'repair')->count(),
            'rental_fleet'=> Vehicle::where('type', 'rental')->count(),
            'garage_fleet'=> Vehicle::where('type', 'garage')->count(),
        ]);
    }
}
