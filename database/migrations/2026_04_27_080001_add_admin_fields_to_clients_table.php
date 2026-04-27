<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('phone2')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('nationality')->nullable()->after('city');
            $table->string('profession')->nullable()->after('nationality');
            $table->date('date_of_birth')->nullable()->after('profession');
            $table->enum('id_type', ['cni', 'passeport', 'permis', 'autre'])->nullable()->after('date_of_birth');
            $table->string('id_number')->nullable()->after('id_type');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['phone2','city','nationality','profession','date_of_birth','id_type','id_number']);
        });
    }
};
