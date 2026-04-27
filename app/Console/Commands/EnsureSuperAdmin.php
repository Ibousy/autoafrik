<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class EnsureSuperAdmin extends Command
{
    protected $signature   = 'autoafrik:ensure-super-admin';
    protected $description = 'Create the platform super admin account if not present';

    public function handle(): int
    {
        $email    = env('SUPERADMIN_EMAIL', 'superadmin@autoafrik.com');
        $password = env('SUPERADMIN_PASSWORD', 'superadmin123');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name'       => 'Super Admin',
                'role'       => 'super_admin',
                'password'   => Hash::make($password),
                'is_active'  => true,
                'company_id' => null,
            ]
        );

        if (!$user->wasRecentlyCreated && $user->role !== 'super_admin') {
            $user->update(['role' => 'super_admin', 'company_id' => null]);
        }

        $this->info("✓ Super admin: {$user->email}");
        return self::SUCCESS;
    }
}
