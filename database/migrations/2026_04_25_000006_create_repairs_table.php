<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
            $table->enum('priority', ['normal', 'high', 'urgent'])->default('normal');
            $table->text('description');
            $table->text('diagnosis')->nullable();
            $table->unsignedInteger('labor_cost')->default(0)->comment('FCFA');
            $table->unsignedInteger('parts_cost')->default(0)->comment('FCFA — auto-calculated');
            $table->unsignedInteger('total_cost')->default(0)->comment('FCFA');
            $table->enum('payment_status', ['paid', 'pending', 'partial'])->default('pending');
            $table->timestamp('entered_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
