<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Current month revenues
        $transactions = [
            // Revenues — Réparations
            ['type' => 'revenue', 'category' => 'reparation', 'amount' => 85000,  'description' => 'Réparation Honda CRV — DK-5541-EF (vidange)', 'date' => now()->subDays(3)],
            ['type' => 'revenue', 'category' => 'reparation', 'amount' => 200000, 'description' => 'Réparation Hyundai i20 — DK-4420-IJ (pneus)', 'date' => now()->subDays(5)],
            ['type' => 'revenue', 'category' => 'reparation', 'amount' => 95000,  'description' => 'Réparation Toyota Corolla — DK-2847-AB (batterie)', 'date' => now()->subDays(20)],
            ['type' => 'revenue', 'category' => 'reparation', 'amount' => 165000, 'description' => 'Réparation Honda CRV — DK-5541-EF (amortisseurs)', 'date' => now()->subDays(22)],
            ['type' => 'revenue', 'category' => 'reparation', 'amount' => 148000, 'description' => 'Réparation Hyundai i20 — DK-4420-IJ (bougies)', 'date' => now()->subMonths(2)->subDays(2)],
            // Revenues — Locations
            ['type' => 'revenue', 'category' => 'location', 'amount' => 175000, 'description' => 'Location Toyota RAV4 — Fatou Diallo (5j)', 'date' => now()->subDays(15)],
            ['type' => 'revenue', 'category' => 'location', 'amount' => 140000, 'description' => 'Location Dacia Duster — Ndéye Mbaye (5j)', 'date' => now()->subDays(13)],
            ['type' => 'revenue', 'category' => 'location', 'amount' => 210000, 'description' => 'Location Peugeot 3008 — Pape Gueye (5j)', 'date' => now()->subDays(10)],
            ['type' => 'revenue', 'category' => 'location', 'amount' => 155000, 'description' => 'Location Suzuki Vitara — Khadija Diallo (5j)', 'date' => now()->subDays(25)],
            ['type' => 'revenue', 'category' => 'location', 'amount' => 225000, 'description' => 'Location Toyota RAV4 — Fatou Diallo (ancien)', 'date' => now()->subDays(38)],
            // Expenses
            ['type' => 'expense', 'category' => 'salaires',     'amount' => 1580000, 'description' => 'Salaires mensuels — Avril 2026',              'date' => now()->subDays(5)],
            ['type' => 'expense', 'category' => 'achat_pieces', 'amount' => 850000,  'description' => 'Achat pièces — Benna Motors (plaquettes, disques)', 'date' => now()->subDays(8)],
            ['type' => 'expense', 'category' => 'achat_pieces', 'amount' => 650000,  'description' => 'Achat pièces — AutoParts SN (filtres, pneus)', 'date' => now()->subDays(12)],
            ['type' => 'expense', 'category' => 'achat_pieces', 'amount' => 650000,  'description' => 'Achat pièces — Total Sénégal (huiles, filtres)', 'date' => now()->subDays(15)],
            ['type' => 'expense', 'category' => 'charges',      'amount' => 220000,  'description' => 'Facture SENELEC + SDE — Avril 2026',           'date' => now()->subDays(10)],
            ['type' => 'expense', 'category' => 'charges',      'amount' => 180000,  'description' => 'Loyer atelier — Avril 2026',                   'date' => now()->subDays(1)],
            ['type' => 'expense', 'category' => 'charges',      'amount' => 100000,  'description' => 'Internet + téléphone professionnel',           'date' => now()->subDays(6)],
            // Previous months
            ['type' => 'revenue', 'category' => 'reparation', 'amount' => 6800000, 'description' => 'Total réparations — Mars 2026', 'date' => now()->subMonths(1)->startOfMonth()],
            ['type' => 'revenue', 'category' => 'location',   'amount' => 4900000, 'description' => 'Total locations — Mars 2026',   'date' => now()->subMonths(1)->startOfMonth()],
            ['type' => 'expense', 'category' => 'salaires',   'amount' => 1580000, 'description' => 'Salaires — Mars 2026',          'date' => now()->subMonths(1)->startOfMonth()],
            ['type' => 'expense', 'category' => 'achat_pieces','amount' => 2100000,'description' => 'Achats pièces — Mars 2026',     'date' => now()->subMonths(1)->startOfMonth()],
            ['type' => 'revenue', 'category' => 'reparation', 'amount' => 5900000, 'description' => 'Total réparations — Fév 2026',  'date' => now()->subMonths(2)->startOfMonth()],
            ['type' => 'revenue', 'category' => 'location',   'amount' => 3800000, 'description' => 'Total locations — Fév 2026',    'date' => now()->subMonths(2)->startOfMonth()],
            ['type' => 'expense', 'category' => 'salaires',   'amount' => 1580000, 'description' => 'Salaires — Fév 2026',           'date' => now()->subMonths(2)->startOfMonth()],
            ['type' => 'revenue', 'category' => 'reparation', 'amount' => 6200000, 'description' => 'Total réparations — Jan 2026',  'date' => now()->subMonths(3)->startOfMonth()],
            ['type' => 'revenue', 'category' => 'location',   'amount' => 4200000, 'description' => 'Total locations — Jan 2026',    'date' => now()->subMonths(3)->startOfMonth()],
            ['type' => 'expense', 'category' => 'salaires',   'amount' => 1580000, 'description' => 'Salaires — Jan 2026',           'date' => now()->subMonths(3)->startOfMonth()],
        ];

        foreach ($transactions as $t) {
            Transaction::create([
                'type'        => $t['type'],
                'category'    => $t['category'],
                'amount'      => $t['amount'],
                'description' => $t['description'],
                'date'        => $t['date'] instanceof \Illuminate\Support\Carbon
                    ? $t['date']->toDateString() : $t['date'],
            ]);
        }
    }
}
