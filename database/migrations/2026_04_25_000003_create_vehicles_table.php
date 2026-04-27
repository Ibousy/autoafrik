<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['garage', 'rental'])->default('rental');
            $table->string('brand');
            $table->string('model');
            $table->string('registration')->unique();
            $table->year('year');
            $table->enum('fuel_type', ['essence', 'diesel', 'electrique', 'hybride'])->default('essence');
            $table->enum('transmission', ['manuel', 'automatique'])->default('manuel');
            $table->unsignedTinyInteger('seats')->default(5);
            $table->unsignedInteger('mileage')->default(0);
            $table->unsignedInteger('price_per_day')->nullable()->comment('FCFA — for rental vehicles');
            $table->enum('status', ['available', 'rented', 'maintenance', 'repair'])->default('available');
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
