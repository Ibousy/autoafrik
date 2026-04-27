<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Users: add company_id + owner role
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->enum('role', ['owner', 'admin', 'manager', 'mechanic', 'accountant', 'receptionist'])
                  ->default('owner')->change();
        });

        foreach (['clients', 'vehicles', 'employees', 'repairs', 'rentals', 'stock_items', 'transactions'] as $tbl) {
            Schema::table($tbl, function (Blueprint $table) {
                $table->foreignId('company_id')->nullable()->after('id')->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_id');
        });

        foreach (['clients', 'vehicles', 'employees', 'repairs', 'rentals', 'stock_items', 'transactions'] as $tbl) {
            Schema::table($tbl, function (Blueprint $table) {
                $table->dropConstrainedForeignId('company_id');
            });
        }
    }
};
