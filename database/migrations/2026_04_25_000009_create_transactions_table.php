<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['revenue', 'expense']);
            $table->enum('category', [
                'reparation',
                'location',
                'salaires',
                'fournitures',
                'charges',
                'achat_pieces',
                'autre',
            ]);
            $table->unsignedInteger('amount')->comment('FCFA');
            $table->string('description');
            $table->nullableMorphs('reference');   // links to repair/rental
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
