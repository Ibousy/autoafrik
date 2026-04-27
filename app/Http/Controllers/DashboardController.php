<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Rental;
use App\Models\Repair;
use App\Models\Transaction;
use App\Models\Vehicle;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_revenue'       => Transaction::where('type', 'revenue')
                ->whereMonth('date', now()->month)->sum('amount'),
            'repairs_in_progress' => Repair::whereIn('status', ['pending', 'in_progress'])->count(),
            'active_rentals'      => Rental::where('status', 'active')->count(),
            'available_vehicles'  => Vehicle::where('type', 'rental')->where('status', 'available')->count(),
            'total_clients'       => Client::count(),
            'total_employees'     => Employee::where('status', 'active')->count(),
        ];

        $recentRepairs = Repair::with(['vehicle', 'client', 'employee'])
            ->latest()->limit(5)->get();

        $recentRentals = Rental::with(['vehicle', 'client'])
            ->latest()->limit(5)->get();

        // Monthly revenue chart data (last 6 months)
        $revenueChart = $this->buildRevenueChart();

        // Weekly activity (last 7 days)
        $weeklyChart = $this->buildWeeklyChart();

        return view('app', compact(
            'stats', 'recentRepairs', 'recentRentals', 'revenueChart', 'weeklyChart'
        ));
    }

    private function buildRevenueChart(): array
    {
        $labels  = [];
        $garage  = [];
        $rental  = [];

        for ($i = 5; $i >= 0; $i--) {
            $date     = now()->subMonths($i);
            $labels[] = $date->translatedFormat('M');

            $garage[] = Transaction::where('type', 'revenue')
                ->where('category', 'reparation')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $rental[] = Transaction::where('type', 'revenue')
                ->where('category', 'location')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
        }

        return compact('labels', 'garage', 'rental');
    }

    private function buildWeeklyChart(): array
    {
        $days    = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        $repairs = [];
        $rentals = [];

        for ($i = 5; $i >= 0; $i--) {
            $date      = now()->subDays($i);
            $repairs[] = Repair::whereDate('created_at', $date)->count();
            $rentals[] = Rental::whereDate('created_at', $date)->count();
        }

        return ['labels' => $days, 'repairs' => $repairs, 'rentals' => $rentals];
    }
}
