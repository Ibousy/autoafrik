<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            // ── Rental fleet
            ['type' => 'rental', 'brand' => 'Toyota',   'model' => 'RAV4',       'registration' => 'DK-4812-AA', 'year' => 2022, 'fuel_type' => 'essence', 'transmission' => 'automatique', 'seats' => 5, 'mileage' => 42800, 'price_per_day' => 35000, 'status' => 'available', 'color' => 'Blanc'],
            ['type' => 'rental', 'brand' => 'Hyundai',  'model' => 'Tucson',     'registration' => 'DK-3921-AB', 'year' => 2023, 'fuel_type' => 'diesel',  'transmission' => 'automatique', 'seats' => 5, 'mileage' => 18200, 'price_per_day' => 40000, 'status' => 'rented',    'color' => 'Gris'],
            ['type' => 'rental', 'brand' => 'Kia',      'model' => 'Sportage',   'registration' => 'DK-7734-AC', 'year' => 2021, 'fuel_type' => 'essence', 'transmission' => 'manuel',      'seats' => 5, 'mileage' => 67400, 'price_per_day' => 32000, 'status' => 'maintenance','color' => 'Noir'],
            ['type' => 'rental', 'brand' => 'Dacia',    'model' => 'Duster',     'registration' => 'DK-2256-AD', 'year' => 2023, 'fuel_type' => 'diesel',  'transmission' => 'manuel',      'seats' => 5, 'mileage' => 12100, 'price_per_day' => 28000, 'status' => 'available', 'color' => 'Bleu'],
            ['type' => 'rental', 'brand' => 'Nissan',   'model' => 'Qashqai',    'registration' => 'DK-5589-AE', 'year' => 2022, 'fuel_type' => 'essence', 'transmission' => 'automatique', 'seats' => 5, 'mileage' => 31500, 'price_per_day' => 38000, 'status' => 'rented',    'color' => 'Argent'],
            ['type' => 'rental', 'brand' => 'Peugeot',  'model' => '3008',       'registration' => 'DK-1147-AF', 'year' => 2023, 'fuel_type' => 'diesel',  'transmission' => 'automatique', 'seats' => 5, 'mileage' => 9800,  'price_per_day' => 42000, 'status' => 'available', 'color' => 'Rouge'],
            ['type' => 'rental', 'brand' => 'Renault',  'model' => 'Captur',     'registration' => 'DK-8823-AG', 'year' => 2022, 'fuel_type' => 'essence', 'transmission' => 'automatique', 'seats' => 5, 'mileage' => 25300, 'price_per_day' => 30000, 'status' => 'rented',    'color' => 'Blanc'],
            ['type' => 'rental', 'brand' => 'Ford',     'model' => 'EcoSport',   'registration' => 'DK-9912-AH', 'year' => 2021, 'fuel_type' => 'essence', 'transmission' => 'manuel',      'seats' => 5, 'mileage' => 48900, 'price_per_day' => 26000, 'status' => 'available', 'color' => 'Noir'],
            ['type' => 'rental', 'brand' => 'Volkswagen','model' => 'Tiguan',    'registration' => 'DK-6634-AI', 'year' => 2023, 'fuel_type' => 'diesel',  'transmission' => 'automatique', 'seats' => 5, 'mileage' => 5600,  'price_per_day' => 45000, 'status' => 'rented',    'color' => 'Gris'],
            ['type' => 'rental', 'brand' => 'Suzuki',   'model' => 'Vitara',     'registration' => 'DK-3345-AJ', 'year' => 2022, 'fuel_type' => 'essence', 'transmission' => 'automatique', 'seats' => 5, 'mileage' => 33700, 'price_per_day' => 31000, 'status' => 'available', 'color' => 'Blanc'],
            ['type' => 'rental', 'brand' => 'Mitsubishi','model' => 'ASX',       'registration' => 'DK-7778-AK', 'year' => 2021, 'fuel_type' => 'diesel',  'transmission' => 'manuel',      'seats' => 5, 'mileage' => 72000, 'price_per_day' => 25000, 'status' => 'rented',    'color' => 'Argent'],
            ['type' => 'rental', 'brand' => 'Honda',    'model' => 'HR-V',       'registration' => 'DK-4456-AL', 'year' => 2022, 'fuel_type' => 'essence', 'transmission' => 'automatique', 'seats' => 5, 'mileage' => 27600, 'price_per_day' => 33000, 'status' => 'rented',    'color' => 'Bleu'],
            // ── Garage clients vehicles
            ['type' => 'garage', 'brand' => 'Toyota',   'model' => 'Corolla',    'registration' => 'DK-2847-AB', 'year' => 2019, 'fuel_type' => 'essence', 'transmission' => 'manuel',      'seats' => 5, 'mileage' => 98400, 'price_per_day' => null, 'status' => 'repair', 'color' => 'Blanc'],
            ['type' => 'garage', 'brand' => 'Renault',  'model' => 'Clio',       'registration' => 'DK-1923-CD', 'year' => 2018, 'fuel_type' => 'essence', 'transmission' => 'manuel',      'seats' => 5, 'mileage' => 112000,'price_per_day' => null, 'status' => 'repair', 'color' => 'Rouge'],
            ['type' => 'garage', 'brand' => 'Honda',    'model' => 'CRV',        'registration' => 'DK-5541-EF', 'year' => 2020, 'fuel_type' => 'diesel',  'transmission' => 'automatique', 'seats' => 5, 'mileage' => 64200, 'price_per_day' => null, 'status' => 'available', 'color' => 'Noir'],
            ['type' => 'garage', 'brand' => 'Peugeot',  'model' => '208',        'registration' => 'DK-3318-GH', 'year' => 2020, 'fuel_type' => 'essence', 'transmission' => 'manuel',      'seats' => 5, 'mileage' => 55800, 'price_per_day' => null, 'status' => 'repair', 'color' => 'Bleu'],
            ['type' => 'garage', 'brand' => 'Hyundai',  'model' => 'i20',        'registration' => 'DK-4420-IJ', 'year' => 2017, 'fuel_type' => 'essence', 'transmission' => 'manuel',      'seats' => 5, 'mileage' => 143000,'price_per_day' => null, 'status' => 'available', 'color' => 'Blanc'],
            ['type' => 'garage', 'brand' => 'Dacia',    'model' => 'Logan',      'registration' => 'DK-7723-QR', 'year' => 2016, 'fuel_type' => 'essence', 'transmission' => 'manuel',      'seats' => 5, 'mileage' => 187000,'price_per_day' => null, 'status' => 'available', 'color' => 'Gris'],
            ['type' => 'garage', 'brand' => 'Volkswagen','model' => 'Golf',      'registration' => 'DK-8812-MN', 'year' => 2018, 'fuel_type' => 'diesel',  'transmission' => 'manuel',      'seats' => 5, 'mileage' => 134000,'price_per_day' => null, 'status' => 'repair', 'color' => 'Noir'],
        ];

        foreach ($vehicles as $v) {
            Vehicle::firstOrCreate(['registration' => $v['registration']], $v);
        }
    }
}
