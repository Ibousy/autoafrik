<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockItemRequest;
use App\Models\AppNotification;
use App\Models\StockItem;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = StockItem::query()
            ->when($request->category, fn ($q, $c) => $q->where('category', $c))
            ->when($request->stock_status === 'low',      fn ($q) => $q->whereRaw('quantity <= min_quantity AND quantity > 0'))
            ->when($request->stock_status === 'critical', fn ($q) => $q->where('quantity', 0))
            ->when($request->search, fn ($q, $s) =>
                $q->where('name', 'like', "%$s%")
                  ->orWhere('reference', 'like', "%$s%")
                  ->orWhere('supplier', 'like', "%$s%")
            )
            ->orderBy('quantity')
            ->paginate(20);

        return response()->json($items);
    }

    public function store(StoreStockItemRequest $request): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me   = $request->user();
        $item = StockItem::create(array_merge($request->validated(), ['company_id' => $me->company_id]));

        return response()->json([
            'message' => 'Pièce ajoutée au stock.',
            'item'    => $item,
        ], 201);
    }

    public function show(StockItem $stock): JsonResponse
    {
        $stock->load(['repairParts.repair.vehicle']);
        return response()->json($stock);
    }

    public function update(StoreStockItemRequest $request, StockItem $stock): JsonResponse
    {
        $stock->update($request->validated());

        return response()->json([
            'message' => 'Pièce mise à jour.',
            'item'    => $stock->fresh(),
        ]);
    }

    public function destroy(StockItem $stock): JsonResponse
    {
        $stock->delete();
        return response()->json(['message' => 'Pièce supprimée.']);
    }

    public function restock(Request $request, StockItem $stockItem): JsonResponse
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
            'cost'     => 'nullable|integer|min:0',
        ]);

        $wasZero = $stockItem->quantity === 0;
        $stockItem->increment('quantity', $data['quantity']);

        if ($wasZero) {
            AppNotification::notifyAll(
                $me->company_id,
                "Stock réapprovisionné",
                "{$stockItem->name} — rupture résolue (+{$data['quantity']})",
                'success', 'box', 'stock'
            );
        }

        if (!empty($data['cost'])) {
            Transaction::create([
                'company_id'  => $me->company_id,
                'type'        => 'expense',
                'category'    => 'achat_pieces',
                'amount'      => $data['cost'],
                'description' => "Réapprovisionnement — {$stockItem->name} (x{$data['quantity']})",
                'date'        => now()->toDateString(),
            ]);
        }

        return response()->json([
            'message' => "Stock mis à jour. Nouvelle quantité : {$stockItem->fresh()->quantity}",
            'item'    => $stockItem->fresh(),
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total'    => StockItem::count(),
            'normal'   => StockItem::whereRaw('quantity > min_quantity')->count(),
            'low'      => StockItem::whereRaw('quantity <= min_quantity AND quantity > 0')->count(),
            'critical' => StockItem::where('quantity', 0)->count(),
            'total_value' => StockItem::selectRaw('SUM(quantity * unit_price) as val')->value('val') ?? 0,
        ]);
    }
}
