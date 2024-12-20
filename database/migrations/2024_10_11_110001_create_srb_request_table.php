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
        Schema::create('srb_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surety_bond_id')->unsigned()->nullable()->references('id')->on('surety_bond');
            $table->foreignId('requested_by')->unsigned()->nullable()->references('id')->on('users');
            $table->timestamp('requested_at')->nullable();
            $table->foreignId('requested_to')->unsigned()->nullable()->references('id')->on('users');
            $table->boolean('is_accepted')->default(0);
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srb_request');
    }
};
