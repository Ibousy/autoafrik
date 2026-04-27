<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Amadou Mbaye',    'email' => 'admin@garagepro.sn',    'role' => 'admin',        'phone' => '+221 77 100 00 01'],
            ['name' => 'Fatima Diouf',    'email' => 'reception@garagepro.sn','role' => 'receptionist', 'phone' => '+221 77 100 00 02'],
            ['name' => 'Oumar Diaw',      'email' => 'o.diaw@garagepro.sn',   'role' => 'mechanic',     'phone' => '+221 77 100 00 03'],
            ['name' => 'Ibou Sarr',       'email' => 'i.sarr@garagepro.sn',   'role' => 'mechanic',     'phone' => '+221 77 100 00 04'],
            ['name' => 'Alioune Ndiaye',  'email' => 'a.ndiaye@garagepro.sn', 'role' => 'mechanic',     'phone' => '+221 77 100 00 05'],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(['email' => $u['email']], array_merge($u, [
                'password'  => Hash::make('password'),
                'is_active' => true,
            ]));
        }
    }
}
