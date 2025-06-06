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
        Schema::create('table_users', function (Blueprint $table) {
            $table->string('no_induk', 20)->primary();
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->string('password');
            $table->string('nama_lengkap'); 
            $table->string('email')->nullable();
            $table->string('nomor_telp')->nullable();
            $table->timestamps();

            $table->foreign('level_id')->references('level_id')->on('table_level');
            $table->foreign('prodi_id')->references('prodi_id')->on('table_prodi');
            $table->foreign('jurusan_id')->references('jurusan_id')->on('table_jurusan');
        });

        Schema::create('table_laporan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->string('kode_laporan', 10);
            $table->string('no_induk', 20);
            $table->unsignedBigInteger('fasilitas_id');
            $table->timestamp('tanggal_laporan');
            $table->text('deskripsi_kerusakan');
            $table->enum('status_perbaikan', ['diproses', 'tuntas'])->nullable();
            $table->enum('status_acc', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->string('foto_kerusakan', 255)->nullable();

            $table->foreign('no_induk')->references('no_induk')->on('table_users');
            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('table_fasilitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_laporan');
        Schema::dropIfExists('table_users');
    }
};
