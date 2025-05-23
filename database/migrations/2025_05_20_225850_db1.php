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
        Schema::create('table_level', function (Blueprint $table) {
            $table->id('level_id');
            $table->string('level_nama', 50);
            $table->timestamps();
        });

        Schema::create('table_jurusan', function (Blueprint $table) {
            $table->id('jurusan_id');
            $table->string('jurusan_nama', 50);
            $table->string('jurusan_kode');
            $table->timestamps();
        });

        Schema::create('table_prodi', function (Blueprint $table) {
            $table->id('prodi_id');
            $table->unsignedBigInteger('jurusan_id');
            $table->string('prodi_nama', 100);
            $table->string('prodi_kode', 10);
            $table->timestamps();

            $table->foreign('jurusan_id')->references('jurusan_id')->on('table_jurusan');
        });

        Schema::create('table_users', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('jurusan_id');
            $table->string('username');
            $table->string('password');
            $table->string('nama_lengkap');
            $table->string('email')->nullable();
            $table->string('nomor_telp')->nullable();
            $table->string('nip')->nullable();
            $table->string('nim')->nullable();
            $table->timestamps();

            $table->foreign('level_id')->references('level_id')->on('table_level');
            $table->foreign('prodi_id')->references('prodi_id')->on('table_prodi');
            $table->foreign('jurusan_id')->references('jurusan_id')->on('table_jurusan');
        });

        Schema::create('table_gedung', function (Blueprint $table) {
            $table->id('gedung_id');
            $table->string('gedung_nama');
            $table->string('gedung_kode');
            $table->timestamps();
        });

        Schema::create('table_fasilitas', function (Blueprint $table) {
            $table->id('fasilitas_id');
            $table->unsignedBigInteger('gedung_id');
            $table->string('nama_fasilitas');
            $table->string('kode_fasilitas');
            $table->date('tanggal_pengadaan');
            $table->enum('status', ['baik', 'rusak', 'perlu perbaikan'])->default('baik');
            $table->string('lantai', 50);
            $table->string('ruangan', 50);

            $table->foreign('gedung_id')->references('gedung_id')->on('table_gedung');
        });

        Schema::create('table_laporan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->string('kode_laporan', 10);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('fasilitas_id');
            $table->timestamp('tanggal_laporan');
            $table->text('deskripsi_kerusakan');
            $table->enum('status_perbaikan', ['diproses', 'tuntas'])->nullable();
            $table->enum('status_acc', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->string('foto_kerusakan', 255)->nullable();

            $table->foreign('user_id')->references('user_id')->on('table_users');
            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('table_fasilitas');
        });

        Schema::create('table_kriteria', function (Blueprint $table) {
            $table->id('kriteria_id');
            $table->string('kode_kriteria', 10);
            $table->timestamps();
            $table->integer('bobot');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe_kriteria', ['cost', 'benefit']);
        });

        Schema::create('table_alternatif', function (Blueprint $table) {
            $table->id('alternatif_id');
            $table->string('alternatif_kode', 10);
            $table->unsignedBigInteger('fasilitas_id');

            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('table_fasilitas');
        });

        Schema::create('table_penilaian', function (Blueprint $table) {
            $table->id('N_alternatif_id');
            $table->unsignedBigInteger('alternatif_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->integer('nilai');

            $table->foreign('alternatif_id')->references('alternatif_id')->on('table_alternatif');
            $table->foreign('kriteria_id')->references('kriteria_id')->on('table_kriteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_penilaian');
        Schema::dropIfExists('table_alternatif');
        Schema::dropIfExists('table_riteria');
        Schema::dropIfExists('table_laporan');
        Schema::dropIfExists('table_fasilitas');
        Schema::dropIfExists('table_gedung');
        Schema::dropIfExists('table_users');
        Schema::dropIfExists('table_prodi');
        Schema::dropIfExists('table_jurusan');
        Schema::dropIfExists('table_level');
    }
};
