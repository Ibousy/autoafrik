<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Company;
use App\Models\Employee;
use App\Models\StockItem;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class EnsureDemo extends Command
{
    protected $signature   = 'autoafrik:ensure-demo';
    protected $description = 'Create demo company + seed users if not present';

    public function handle(): int
    {
        // ── Demo company
        $company = Company::firstOrCreate(
            ['slug' => 'garagepro-demo'],
            [
                'name'          => 'GaragePro Démo',
                'address'       => 'Dakar, Sénégal',
                'phone'         => '+221 33 800 00 00',
                'email'         => 'contact@garagepro.sn',
                'currency'      => 'FCFA',
                'plan'          => 'pro',
                'plan_expires_at' => now()->addYears(10),
                'max_agents'    => 20,
                'status'        => 'active',
            ]
        );

        // ── Demo users
        $users = [
            ['name' => 'Propriétaire Demo', 'email' => 'owner@garagepro.sn',      'role' => 'owner'],
            ['name' => 'Amadou Mbaye',       'email' => 'admin@garagepro.sn',      'role' => 'admin'],
            ['name' => 'Fatima Diouf',       'email' => 'reception@garagepro.sn', 'role' => 'receptionist'],
            ['name' => 'Oumar Diaw',         'email' => 'mecano@garagepro.sn',    'role' => 'mechanic'],
            ['name' => 'Rokhaya Sow',        'email' => 'compta@garagepro.sn',    'role' => 'accountant'],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(
                ['email' => $u['email']],
                array_merge($u, [
                    'company_id' => $company->id,
                    'password'   => Hash::make('password'),
                    'is_active'  => true,
                    'phone'      => '+221 77 000 00 0' . array_search($u, $users),
                ])
            );
        }

        // Ensure existing users without a company are assigned this one
        User::whereNull('company_id')->update(['company_id' => $company->id]);

        $this->info("✓ Demo company: {$company->name} (id={$company->id})");
        $this->info("✓ Users: " . User::where('company_id', $company->id)->count() . " users");
        $this->info("  owner@garagepro.sn / password");
        $this->info("  admin@garagepro.sn / password");

        return self::SUCCESS;
    }
}
