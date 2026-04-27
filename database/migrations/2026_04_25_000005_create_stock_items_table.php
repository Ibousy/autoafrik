<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('name');
            $table->enum('category', [
                'freinage',
                'moteur',
                'climatisation',
                'pneumatiques',
                'electrique',
                'transmission',
                'carrosserie',
                'echappement',
                'autre',
            ])->default('autre');
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('min_quantity')->default(5)->comment('Seuil d\'alerte');
            $table->unsignedInteger('unit_price')->default(0)->comment('FCFA');
            $table->string('supplier')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_items');
    }
};
