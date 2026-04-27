<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $transactions = Transaction::query()
            ->when($request->type,     fn ($q, $t) => $q->where('type', $t))
            ->when($request->category, fn ($q, $c) => $q->where('category', $c))
            ->when($request->month,    fn ($q, $m) => $q->whereMonth('date', $m))
            ->when($request->year,     fn ($q, $y) => $q->whereYear('date', $y))
            ->when($request->search,   fn ($q, $s) =>
                $q->where('description', 'like', "%$s%")
            )
            ->latest('date')
            ->paginate(20);

        return response()->json($transactions);
    }

    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = Transaction::create(array_merge($request->validated(), ['company_id' => auth()->user()?->company_id]));

        return response()->json([
            'message'     => 'Transaction enregistrée.',
            'transaction' => $transaction,
        ], 201);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return response()->json($transaction);
    }

    public function update(StoreTransactionRequest $request, Transaction $transaction): JsonResponse
    {
        $transaction->update($request->validated());
        return response()->json(['message' => 'Transaction mise à jour.', 'transaction' => $transaction->fresh()]);
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        $transaction->delete();
        return response()->json(['message' => 'Transaction supprimée.']);
    }

    public function summary(Request $request): JsonResponse
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year  ?? now()->year;

        $base = Transaction::whereMonth('date', $month)->whereYear('date', $year);

        $totalRevenue  = (clone $base)->where('type', 'revenue')->sum('amount');
        $totalExpense  = (clone $base)->where('type', 'expense')->sum('amount');
        $netProfit     = $totalRevenue - $totalExpense;
        $margin        = $totalRevenue > 0 ? round(($netProfit / $totalRevenue) * 100, 1) : 0;

        $revenueByCategory = (clone $base)->where('type', 'revenue')
            ->groupBy('category')
            ->selectRaw('category, SUM(amount) as total')
            ->pluck('total', 'category');

        $expenseByCategory = (clone $base)->where('type', 'expense')
            ->groupBy('category')
            ->selectRaw('category, SUM(amount) as total')
            ->pluck('total', 'category');

        return response()->json([
            'total_revenue'       => $totalRevenue,
            'total_expense'       => $totalExpense,
            'net_profit'          => $netProfit,
            'margin'              => $margin,
            'revenue_by_category' => $revenueByCategory,
            'expense_by_category' => $expenseByCategory,
        ]);
    }
}
