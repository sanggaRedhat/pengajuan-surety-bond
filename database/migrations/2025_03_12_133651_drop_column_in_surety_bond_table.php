<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surety_bond', function (Blueprint $table) {
            $table->dropColumn('berkas_umum_6');
            $table->dropColumn('berkas_perorangan_1');
            $table->dropColumn('berkas_perorangan_2');
            $table->dropColumn('berkas_perorangan_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surety_bond', function (Blueprint $table) {
            //
        });
    }
};
