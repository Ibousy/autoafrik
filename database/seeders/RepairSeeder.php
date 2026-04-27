<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Repair;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class RepairSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles  = Vehicle::where('type', 'garage')->pluck('id', 'registration');
        $clients   = Client::pluck('id')->toArray();
        $mechanics = Employee::whereIn('role', ['chef_mecanicien','mecanicien_senior','mecanicien','electricien'])->pluck('id')->toArray();

        $repairs = [
            [
                'vehicle_reg'  => 'DK-2847-AB', 'client_idx' => 0, 'mech_idx' => 0,
                'status'       => 'in_progress', 'priority' => 'normal',
                'description'  => 'Freins avant + remplacement plaquettes',
                'labor_cost'   => 45000, 'payment_status' => 'pending',
                'entered_at'   => now()->subDays(3),
            ],
            [
                'vehicle_reg'  => 'DK-1923-CD', 'client_idx' => 1, 'mech_idx' => 1,
                'status'       => 'pending', 'priority' => 'normal',
                'description'  => 'Révision générale — 60 000 km',
                'labor_cost'   => 65000, 'payment_status' => 'pending',
                'entered_at'   => now()->subDays(1),
            ],
            [
                'vehicle_reg'  => 'DK-5541-EF', 'client_idx' => 2, 'mech_idx' => 2,
                'status'       => 'done', 'priority' => 'normal',
                'description'  => 'Vidange complète + filtre à huile',
                'labor_cost'   => 35000, 'payment_status' => 'paid',
                'entered_at'   => now()->subDays(5), 'completed_at' => now()->subDays(4),
            ],
            [
                'vehicle_reg'  => 'DK-3318-GH', 'client_idx' => 3, 'mech_idx' => 3,
                'status'       => 'in_progress', 'priority' => 'high',
                'description'  => 'Remplacement compresseur climatisation',
                'labor_cost'   => 60000, 'payment_status' => 'pending',
                'entered_at'   => now()->subDays(2),
            ],
            [
                'vehicle_reg'  => 'DK-4420-IJ', 'client_idx' => 4, 'mech_idx' => 4,
                'status'       => 'done', 'priority' => 'normal',
                'description'  => 'Changement 4 pneus + équilibrage',
                'labor_cost'   => 20000, 'payment_status' => 'paid',
                'entered_at'   => now()->subDays(7), 'completed_at' => now()->subDays(6),
            ],
            [
                'vehicle_reg'  => 'DK-8812-MN', 'client_idx' => 5, 'mech_idx' => 1,
                'status'       => 'pending', 'priority' => 'urgent',
                'description'  => 'Remplacement kit embrayage complet',
                'labor_cost'   => 85000, 'payment_status' => 'pending',
                'entered_at'   => now()->subDays(1),
            ],
            [
                'vehicle_reg'  => 'DK-7723-QR', 'client_idx' => 6, 'mech_idx' => 0,
                'status'       => 'done', 'priority' => 'high',
                'description'  => 'Réparation boîte de vitesses',
                'labor_cost'   => 150000, 'payment_status' => 'pending',
                'entered_at'   => now()->subDays(10), 'completed_at' => now()->subDays(7),
            ],
            [
                'vehicle_reg'  => 'DK-2847-AB', 'client_idx' => 0, 'mech_idx' => 2,
                'status'       => 'done', 'priority' => 'normal',
                'description'  => 'Remplacement batterie + vérification alternateur',
                'labor_cost'   => 15000, 'payment_status' => 'paid',
                'entered_at'   => now()->subMonths(1)->subDays(5), 'completed_at' => now()->subMonths(1)->subDays(4),
            ],
            [
                'vehicle_reg'  => 'DK-5541-EF', 'client_idx' => 2, 'mech_idx' => 3,
                'status'       => 'done', 'priority' => 'normal',
                'description'  => 'Remplacement amortisseurs avant',
                'labor_cost'   => 55000, 'payment_status' => 'paid',
                'entered_at'   => now()->subMonths(1)->subDays(12), 'completed_at' => now()->subMonths(1)->subDays(10),
            ],
            [
                'vehicle_reg'  => 'DK-4420-IJ', 'client_idx' => 4, 'mech_idx' => 1,
                'status'       => 'done', 'priority' => 'normal',
                'description'  => 'Diagnostic moteur + remplacement bougies',
                'labor_cost'   => 25000, 'payment_status' => 'paid',
                'entered_at'   => now()->subMonths(2)->subDays(3), 'completed_at' => now()->subMonths(2)->subDays(2),
            ],
        ];

        foreach ($repairs as $r) {
            $vehicleId = $vehicles[$r['vehicle_reg']] ?? null;
            if (!$vehicleId) continue;

            Repair::create([
                'vehicle_id'     => $vehicleId,
                'client_id'      => $clients[$r['client_idx']],
                'employee_id'    => $mechanics[$r['mech_idx']] ?? null,
                'status'         => $r['status'],
                'priority'       => $r['priority'],
                'description'    => $r['description'],
                'labor_cost'     => $r['labor_cost'],
                'parts_cost'     => 0,
                'total_cost'     => $r['labor_cost'],
                'payment_status' => $r['payment_status'],
                'entered_at'     => $r['entered_at'],
                'completed_at'   => $r['completed_at'] ?? null,
            ]);
        }
    }
}
