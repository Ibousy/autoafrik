<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('owner_name')->nullable()->after('notes');
            $table->string('owner_phone')->nullable()->after('owner_name');
            $table->string('owner_phone2')->nullable()->after('owner_phone');
            $table->string('owner_email')->nullable()->after('owner_phone2');
            $table->string('owner_address')->nullable()->after('owner_email');
            $table->enum('owner_id_type', ['cni', 'passeport', 'permis', 'autre'])->nullable()->after('owner_address');
            $table->string('owner_id_number')->nullable()->after('owner_id_type');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['owner_name','owner_phone','owner_phone2','owner_email','owner_address','owner_id_type','owner_id_number']);
        });
    }
};
