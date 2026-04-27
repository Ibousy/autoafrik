<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Rental;
use App\Models\Repair;
use App\Models\Transaction;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function monthly(Request $request): JsonResponse
    {
        $year = $request->year ?? now()->year;

        $labels  = [];
        $garage  = [];
        $rental  = [];
        $expense = [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[]  = now()->setMonth($m)->format('M');
            $garage[]  = Transaction::where('type', 'revenue')->where('category', 'reparation')
                ->whereMonth('date', $m)->whereYear('date', $year)->sum('amount');
            $rental[]  = Transaction::where('type', 'revenue')->where('category', 'location')
                ->whereMonth('date', $m)->whereYear('date', $year)->sum('amount');
            $expense[] = Transaction::where('type', 'expense')
                ->whereMonth('date', $m)->whereYear('date', $year)->sum('amount');
        }

        return response()->json(compact('labels', 'garage', 'rental', 'expense'));
    }

    public function repairsByCategory(): JsonResponse
    {
        $data = Repair::selectRaw(
            'v.brand, COUNT(*) as count'
        )
        ->join('vehicles as v', 'v.id', '=', 'repairs.vehicle_id')
        ->groupBy('v.brand')
        ->orderByDesc('count')
        ->limit(8)
        ->get();

        // Category distribution for repair types (from description keywords)
        $categories = [
            'Freinage'      => Repair::where('description', 'like', '%frei%')->count(),
            'Moteur'        => Repair::where('description', 'like', '%moteur%')->orWhere('description', 'like', '%vidange%')->count(),
            'Climatisation' => Repair::where('description', 'like', '%clim%')->count(),
            'Pneus'         => Repair::where('description', 'like', '%pneu%')->count(),
            'Électricité'   => Repair::where('description', 'like', '%électr%')->orWhere('description', 'like', '%batterie%')->count(),
            'Transmission'  => Repair::where('description', 'like', '%embray%')->orWhere('description', 'like', '%boîte%')->count(),
            'Autre'         => 0,
        ];

        return response()->json(['by_brand' => $data, 'by_category' => $categories]);
    }

    public function topMechanics(): JsonResponse
    {
        $mechanics = Employee::withCount([
            'repairs as total_repairs',
            'repairs as done_repairs' => fn ($q) => $q->where('status', 'done'),
        ])
        ->whereIn('role', ['chef_mecanicien', 'mecanicien_senior', 'mecanicien', 'electricien'])
        ->where('status', 'active')
        ->get()
        ->map(fn ($e) => [
            'name'          => $e->full_name,
            'role'          => $e->role_label,
            'total_repairs' => $e->total_repairs,
            'done_repairs'  => $e->done_repairs,
            'performance'   => $e->total_repairs > 0
                ? round(($e->done_repairs / $e->total_repairs) * 100) : 0,
        ])
        ->sortByDesc('performance')
        ->values();

        return response()->json($mechanics);
    }

    public function topVehicles(): JsonResponse
    {
        $vehicles = Vehicle::where('type', 'rental')
            ->withCount('rentals')
            ->withSum('rentals as total_revenue', 'total_price')
            ->orderByDesc('rentals_count')
            ->limit(6)
            ->get()
            ->map(fn ($v) => [
                'name'          => $v->full_name,
                'rentals_count' => $v->rentals_count,
                'total_revenue' => $v->total_revenue ?? 0,
            ]);

        return response()->json($vehicles);
    }

    public function topClients(): JsonResponse
    {
        $clients = Client::withSum([
            'repairs as repair_revenue' => fn ($q) => $q->where('payment_status', 'paid'),
        ], 'total_cost')
        ->withSum([
            'rentals as rental_revenue' => fn ($q) => $q->where('payment_status', 'paid'),
        ], 'total_price')
        ->get()
        ->map(fn ($c) => [
            'name'           => $c->full_name,
            'repair_revenue' => $c->repair_revenue ?? 0,
            'rental_revenue' => $c->rental_revenue ?? 0,
            'total'          => ($c->repair_revenue ?? 0) + ($c->rental_revenue ?? 0),
        ])
        ->sortByDesc('total')
        ->values()
        ->take(8);

        return response()->json($clients);
    }
}
