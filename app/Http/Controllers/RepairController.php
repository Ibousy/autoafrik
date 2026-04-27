<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepairRequest;
use App\Models\AppNotification;
use App\Models\Repair;
use App\Models\RepairPart;
use App\Models\StockItem;
use App\Models\Transaction;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $repairs = Repair::with(['vehicle', 'client', 'employee'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->search, fn ($q, $s) =>
                $q->whereHas('vehicle', fn ($v) =>
                    $v->where('brand', 'like', "%$s%")->orWhere('registration', 'like', "%$s%")
                )->orWhereHas('client', fn ($c) =>
                    $c->where('first_name', 'like', "%$s%")->orWhere('last_name', 'like', "%$s%")
                )
            )
            ->latest()
            ->paginate(20);

        return response()->json($repairs);
    }

    public function store(StoreRepairRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user   = $request->user();
        $repair = Repair::create(array_merge($request->validated(), ['company_id' => $user->company_id]));

        $this->syncVehicleStatus($repair->vehicle_id);

        $repair->load(['vehicle', 'client']);
        $vehicleName = $repair->vehicle->full_name ?? 'Véhicule';
        AppNotification::notifyAll(
            $user->company_id,
            "Nouvelle réparation créée",
            "{$vehicleName} — {$repair->type}",
            'warning', 'wrench', 'reparations'
        );

        return response()->json([
            'message' => 'Ordre de réparation créé.',
            'repair'  => $repair->load(['vehicle', 'client', 'employee']),
        ], 201);
    }

    public function show(Repair $repair): JsonResponse
    {
        $repair->load(['vehicle', 'client', 'employee', 'parts.stockItem']);
        return response()->json($repair);
    }

    public function update(StoreRepairRequest $request, Repair $repair): JsonResponse
    {
        $wasNotDone     = $repair->status !== 'done';
        $oldVehicleId   = $repair->vehicle_id;

        $repair->update($request->validated());

        // Sync status for both old and new vehicle (in case vehicle changed)
        $this->syncVehicleStatus($oldVehicleId);
        if ($repair->vehicle_id !== $oldVehicleId) {
            $this->syncVehicleStatus($repair->vehicle_id);
        }

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Notify when repair is marked done
        if ($wasNotDone && $repair->status === 'done') {
            $repair->loadMissing('vehicle');
            AppNotification::notifyAll(
                $user->company_id,
                "Réparation terminée",
                ($repair->vehicle->full_name ?? 'Véhicule') . " — réparation clôturée",
                'success', 'check-circle', 'reparations'
            );
        }

        // Auto-generate transaction when repair is completed and paid
        if ($wasNotDone && $repair->status === 'done' && $repair->payment_status === 'paid') {
            Transaction::create([
                'company_id'     => $user->company_id,
                'type'           => 'revenue',
                'category'       => 'reparation',
                'amount'         => $repair->total_cost,
                'description'    => "Réparation — {$repair->vehicle->full_name} ({$repair->vehicle->registration})",
                'reference_type' => Repair::class,
                'reference_id'   => $repair->id,
                'date'           => now()->toDateString(),
            ]);
        }

        return response()->json([
            'message' => 'Réparation mise à jour.',
            'repair'  => $repair->fresh()->load(['vehicle', 'client', 'employee']),
        ]);
    }

    public function destroy(Repair $repair): JsonResponse
    {
        $vehicleId = $repair->vehicle_id;
        $repair->delete();

        $this->syncVehicleStatus($vehicleId);

        return response()->json(['message' => 'Réparation supprimée.']);
    }

    public function addPart(Request $request, Repair $repair): JsonResponse
    {
        $data = $request->validate([
            'stock_item_id' => 'required|exists:stock_items,id',
            'quantity'      => 'required|integer|min:1',
        ]);

        $stockItem = StockItem::findOrFail($data['stock_item_id']);

        if ($stockItem->quantity < $data['quantity']) {
            return response()->json([
                'message' => "Stock insuffisant. Disponible : {$stockItem->quantity}",
            ], 422);
        }

        $part = RepairPart::create([
            'repair_id'     => $repair->id,
            'stock_item_id' => $stockItem->id,
            'quantity'      => $data['quantity'],
            'unit_price'    => $stockItem->unit_price,
        ]);

        $stockItem->refresh();
        if ($stockItem->quantity <= $stockItem->min_quantity) {
            /** @var \App\Models\User $userStock */
            $userStock = $request->user();
            $label = $stockItem->quantity === 0 ? 'Rupture de stock' : 'Stock faible';
            AppNotification::notifyAll(
                $userStock->company_id,
                $label,
                "{$stockItem->name} — quantité : {$stockItem->quantity}",
                'warning', 'box', 'stock'
            );
        }

        return response()->json([
            'message' => 'Pièce ajoutée.',
            'part'    => $part->load('stockItem'),
            'repair'  => $repair->fresh(),
        ], 201);
    }

    public function removePart(Repair $repair, RepairPart $part): JsonResponse
    {
        abort_if($part->repair_id !== $repair->id, 404);
        $part->delete();

        return response()->json([
            'message' => 'Pièce retirée.',
            'repair'  => $repair->fresh(),
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'pending'       => Repair::where('status', 'pending')->count(),
            'in_progress'   => Repair::where('status', 'in_progress')->count(),
            'done_month'    => Repair::where('status', 'done')
                ->whereMonth('completed_at', now()->month)->count(),
            'revenue_month' => Repair::where('status', 'done')
                ->where('payment_status', 'paid')
                ->whereMonth('completed_at', now()->month)
                ->sum('total_cost'),
        ]);
    }

    // ── Sync vehicle status based on its active repairs
    private function syncVehicleStatus(int $vehicleId): void
    {
        $vehicle = Vehicle::withoutGlobalScopes()->find($vehicleId);
        if (!$vehicle) return;

        // Skip if vehicle is rented — rental takes priority
        if ($vehicle->status === 'rented') return;

        $active = Repair::where('vehicle_id', $vehicleId)
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderByDesc('updated_at')
            ->first();

        if (!$active) {
            $vehicle->update(['status' => 'available']);
            return;
        }

        $vehicle->update([
            'status' => $active->type === 'maintenance' ? 'maintenance' : 'repair',
        ]);
    }
}
