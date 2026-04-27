<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = Vehicle::where('type', 'rental')->pluck('id', 'registration');
        $clients  = Client::pluck('id')->toArray();

        $rentals = [
            ['reg' => 'DK-3921-AB', 'cli' => 0, 'start' => now()->subDays(4),  'end' => now()->addDays(4),  'ppd' => 40000, 'status' => 'active',    'pay' => 'paid',    'method' => 'especes'],
            ['reg' => 'DK-5589-AE', 'cli' => 1, 'start' => now()->subDays(2),  'end' => now()->addDays(7),  'ppd' => 38000, 'status' => 'active',    'pay' => 'pending', 'method' => 'virement'],
            ['reg' => 'DK-8823-AG', 'cli' => 2, 'start' => now()->subDays(6),  'end' => now()->addDays(2),  'ppd' => 30000, 'status' => 'active',    'pay' => 'paid',    'method' => 'mobile_money'],
            ['reg' => 'DK-9912-AH', 'cli' => 3, 'start' => now()->subDays(1),  'end' => now()->addDays(10), 'ppd' => 26000, 'status' => 'active',    'pay' => 'partial', 'method' => 'especes'],
            ['reg' => 'DK-6634-AI', 'cli' => 5, 'start' => now()->subDays(3),  'end' => now()->addDays(5),  'ppd' => 45000, 'status' => 'active',    'pay' => 'paid',    'method' => 'virement'],
            ['reg' => 'DK-7778-AK', 'cli' => 6, 'start' => now()->subDays(8),  'end' => now()->addDays(2),  'ppd' => 25000, 'status' => 'active',    'pay' => 'pending', 'method' => 'especes'],
            ['reg' => 'DK-4456-AL', 'cli' => 7, 'start' => now()->subDays(5),  'end' => now()->addDays(5),  'ppd' => 33000, 'status' => 'active',    'pay' => 'paid',    'method' => 'mobile_money'],
            // Completed
            ['reg' => 'DK-4812-AA', 'cli' => 4, 'start' => now()->subDays(20), 'end' => now()->subDays(15), 'ppd' => 35000, 'status' => 'completed', 'pay' => 'paid',    'method' => 'especes'],
            ['reg' => 'DK-2256-AD', 'cli' => 8, 'start' => now()->subDays(18), 'end' => now()->subDays(13), 'ppd' => 28000, 'status' => 'completed', 'pay' => 'paid',    'method' => 'virement'],
            ['reg' => 'DK-1147-AF', 'cli' => 9, 'start' => now()->subDays(15), 'end' => now()->subDays(10), 'ppd' => 42000, 'status' => 'completed', 'pay' => 'paid',    'method' => 'mobile_money'],
            ['reg' => 'DK-3345-AJ', 'cli' => 10,'start' => now()->subDays(30), 'end' => now()->subDays(25), 'ppd' => 31000, 'status' => 'completed', 'pay' => 'paid',    'method' => 'especes'],
            ['reg' => 'DK-4812-AA', 'cli' => 0, 'start' => now()->subDays(45), 'end' => now()->subDays(38), 'ppd' => 35000, 'status' => 'completed', 'pay' => 'paid',    'method' => 'especes'],
        ];

        foreach ($rentals as $r) {
            $vehicleId = $vehicles[$r['reg']] ?? null;
            if (!$vehicleId) continue;

            $days  = (int) $r['start']->diffInDays($r['end']);
            $total = $days * $r['ppd'];

            Rental::create([
                'vehicle_id'     => $vehicleId,
                'client_id'      => $clients[$r['cli']],
                'start_date'     => $r['start']->toDateString(),
                'end_date'       => $r['end']->toDateString(),
                'price_per_day'  => $r['ppd'],
                'total_price'    => $total,
                'status'         => $r['status'],
                'payment_status' => $r['pay'],
                'payment_method' => $r['method'],
            ]);
        }
    }
}
