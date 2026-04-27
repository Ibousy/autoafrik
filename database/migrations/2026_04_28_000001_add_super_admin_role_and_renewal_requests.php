<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Alter the role enum to include super_admin and owner/accountant
        DB::statement("ALTER TABLE users MODIFY role ENUM('super_admin','owner','admin','manager','mechanic','receptionist','accountant') NOT NULL DEFAULT 'mechanic'");

        // Renewal requests table
        Schema::create('renewal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->enum('plan', ['starter', 'pro', 'enterprise']);
            $table->integer('duration_months')->default(1);
            $table->unsignedInteger('amount');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('renewal_requests');
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','manager','mechanic','receptionist') NOT NULL DEFAULT 'mechanic'");
    }
};
