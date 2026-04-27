<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('price_per_day')->comment('FCFA — snapshot');
            $table->unsignedInteger('days')->storedAs('DATEDIFF(end_date, start_date)');
            $table->unsignedInteger('total_price')->comment('FCFA');
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->enum('payment_status', ['paid', 'pending', 'partial'])->default('pending');
            $table->enum('payment_method', ['especes', 'virement', 'mobile_money'])->default('especes');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
