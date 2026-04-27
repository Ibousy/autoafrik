<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ClientSeeder::class,
            VehicleSeeder::class,
            EmployeeSeeder::class,
            StockItemSeeder::class,
            RepairSeeder::class,
            RentalSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
