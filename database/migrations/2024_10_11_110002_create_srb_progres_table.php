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
        Schema::create('srb_progres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surety_bond_id')->unsigned()->nullable()->references('id')->on('surety_bond');
            $table->foreignId('user_id')->unsigned()->nullable()->references('id')->on('users');
            $table->enum('status', ['Baru', 'Pending Request', 'Proses', 'Selesai', 'Dibatalkan'])->default('Baru');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srb_progres');
    }
};
