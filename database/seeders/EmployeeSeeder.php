<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            ['user_email' => 'admin@garagepro.sn',    'first_name' => 'Amadou',   'last_name' => 'Mbaye',   'role' => 'gerant',            'phone' => '+221 77 100 00 01', 'salary' => 450000, 'hired_at' => '2018-01-15'],
            ['user_email' => 'reception@garagepro.sn','first_name' => 'Fatima',   'last_name' => 'Diouf',   'role' => 'receptionniste',    'phone' => '+221 77 100 00 02', 'salary' => 180000, 'hired_at' => '2019-03-01'],
            ['user_email' => 'o.diaw@garagepro.sn',   'first_name' => 'Oumar',    'last_name' => 'Diaw',    'role' => 'chef_mecanicien',   'phone' => '+221 77 100 00 03', 'salary' => 320000, 'hired_at' => '2018-06-01'],
            ['user_email' => 'i.sarr@garagepro.sn',   'first_name' => 'Ibou',     'last_name' => 'Sarr',    'role' => 'mecanicien_senior', 'phone' => '+221 77 100 00 04', 'salary' => 260000, 'hired_at' => '2019-09-15'],
            ['user_email' => 'a.ndiaye@garagepro.sn', 'first_name' => 'Alioune',  'last_name' => 'Ndiaye',  'role' => 'electricien',       'phone' => '+221 77 100 00 05', 'salary' => 240000, 'hired_at' => '2020-02-01'],
            ['user_email' => null,                     'first_name' => 'Moussa',   'last_name' => 'Ka',      'role' => 'mecanicien',        'phone' => '+221 76 111 22 33', 'salary' => 200000, 'hired_at' => '2020-07-01'],
            ['user_email' => null,                     'first_name' => 'Cheikh',   'last_name' => 'Balde',   'role' => 'mecanicien',        'phone' => '+221 77 222 33 44', 'salary' => 180000, 'hired_at' => '2021-04-15'],
            ['user_email' => null,                     'first_name' => 'Khadim',   'last_name' => 'Diallo',  'role' => 'magasinier',        'phone' => '+221 78 333 44 55', 'salary' => 160000, 'hired_at' => '2021-01-10'],
            ['user_email' => null,                     'first_name' => 'Souleymane','last_name' => 'Niang',  'role' => 'mecanicien',        'phone' => '+221 70 444 55 66', 'salary' => 190000, 'hired_at' => '2022-03-01'],
        ];

        foreach ($employees as $e) {
            $userId = null;
            if ($e['user_email']) {
                $userId = User::where('email', $e['user_email'])->value('id');
            }
            Employee::firstOrCreate(['phone' => $e['phone']], [
                'user_id'    => $userId,
                'first_name' => $e['first_name'],
                'last_name'  => $e['last_name'],
                'role'       => $e['role'],
                'phone'      => $e['phone'],
                'email'      => $e['user_email'],
                'salary'     => $e['salary'],
                'hired_at'   => $e['hired_at'],
                'status'     => 'active',
            ]);
        }
    }
}
