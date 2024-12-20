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
        Schema::create('surety_bond', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned()->nullable()->references('id')->on('users');
            $table->string('no_tiket');
            $table->string('nomor_identitas_pemohon')->nullable();
            $table->string('nama_pemohon');
            $table->string('email_pemohon');
            $table->string('nomor_pemohon');
            $table->string('nama_perusahaan');
            $table->string('jenis_penjaminan');
            $table->decimal('nilai_kontrak', 17, 2);
            $table->string('pekerjaan');
            $table->tinyInteger('jangka_waktu');
            $table->tinyInteger('nilai_jaminan_persen');
            $table->enum('status', ['Baru', 'Pending Request', 'Proses', 'Selesai', 'Dibatalkan'])->default('Baru');
            $table->text('catatan')->nullable();
            $table->string('jenis_berkas_jaminan')->nullable();
            $table->string('berkas_jaminan')->nullable();
            $table->string('berkas_permohonan')->nullable();
            $table->string('berkas_umum_1')->nullable();
            $table->string('berkas_umum_2')->nullable();
            $table->string('berkas_umum_3')->nullable();
            $table->string('berkas_umum_4')->nullable();
            $table->string('berkas_umum_5')->nullable();
            $table->string('berkas_umum_6')->nullable();
            $table->string('berkas_umum_7')->nullable();
            $table->string('berkas_umum_8')->nullable();
            $table->string('berkas_umum_9')->nullable();
            $table->string('berkas_perorangan_1')->nullable();
            $table->string('berkas_perorangan_2')->nullable();
            $table->string('berkas_perorangan_3')->nullable();
            $table->string('berkas_perorangan_4')->nullable();
            $table->string('berkas_khusus_1')->nullable();
            $table->uuid('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surety_bond');
    }
};
