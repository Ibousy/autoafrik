<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('role', [
                'chef_mecanicien',
                'mecanicien_senior',
                'mecanicien',
                'electricien',
                'magasinier',
                'receptionniste',
                'gerant',
                'comptable',
            ])->default('mecanicien');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->unsignedInteger('salary')->default(0)->comment('FCFA/mois');
            $table->date('hired_at');
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
