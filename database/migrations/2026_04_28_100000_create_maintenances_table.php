<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', [
                'vidange', 'revision', 'controle_technique', 'pneumatiques',
                'freins', 'batterie', 'courroie', 'filtre', 'climatisation',
                'geometrie', 'autre',
            ])->default('revision');
            $table->string('description')->nullable();
            $table->date('scheduled_at');
            $table->date('completed_at')->nullable();
            $table->unsignedInteger('mileage')->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            $table->enum('status', ['planifie', 'en_cours', 'termine', 'annule'])->default('planifie');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
