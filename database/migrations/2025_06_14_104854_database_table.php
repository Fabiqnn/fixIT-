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
            $table->string('no_induk', 20)->primary();
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->string('password');
            $table->string('nama_lengkap'); 
            $table->string('email')->nullable();
            $table->string('nomor_telp')->nullable();
            $table->string('foto')->nullable();
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
            $table->timestamps();

            $table->foreign('no_induk')->references('no_induk')->on('table_users');
            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('table_fasilitas');
        });

        Schema::create('table_gedung', function (Blueprint $table) {
            $table->id('gedung_id');
            $table->string('gedung_nama');
            $table->string('gedung_kode');
            $table->timestamps();
        });

        Schema::create('table_lantai', function (Blueprint $table) {
            $table->id('id_lantai');
            $table->string('nama_lantai', 50);
            $table->unsignedBigInteger('gedung_id');
            $table->timestamps();

            $table->foreign('gedung_id')->references('gedung_id')->on('table_gedung');
        });

        Schema::create('table_ruangan', function (Blueprint $table) {
            $table->id('id_ruangan');
            $table->string('kode_ruangan', 20);
            $table->string('keterangan');
            $table->unsignedBigInteger('gedung_id')->unique();
            $table->unsignedBigInteger('id_lantai')->unique();
            $table->timestamps();

            $table->foreign('gedung_id')->references('gedung_id')->on('table_gedung');
            $table->foreign('id_lantai')->references('id_lantai')->on('table_lantai');
        });

        Schema::create('table_fasilitas', function (Blueprint $table) {
            $table->id('fasilitas_id');
            $table->string('nama_fasilitas');
            $table->string('kode_fasilitas');
            $table->date('tanggal_pengadaan');
            $table->enum('status', ['baik', 'rusak', 'dalam perbaikan'])->default('baik');
            $table->unsignedBigInteger('ruangan_id');
            $table->timestamps();

            $table->foreign('ruangan_id')
                ->references('id_ruangan')->on('table_ruangan')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
        
        Schema::create('table_kriteria', function (Blueprint $table) {
            $table->id('kriteria_id');
            $table->string('nama_kriteria', 100);
            $table->integer('bobot');
            $table->enum('tipe_kriteria', ['benefit', 'cost']);
            $table->timestamps();
        });

        Schema::create('table_alternatif', function (Blueprint $table) {
            $table->id('alternatif_id');
            $table->unsignedBigInteger('laporan_id');
            $table->timestamps();

            $table->foreign('laporan_id')->references('laporan_id')->on('table_laporan');
        });

        Schema::create('table_penilaian', function (Blueprint $table) {
            $table->id('penilaian_id');
            $table->unsignedBigInteger('alternatif_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->integer('nilai')->nullable();
            $table->timestamps();

            $table->foreign('alternatif_id')->references('alternatif_id')->on('table_alternatif');
            $table->foreign('kriteria_id')->references('kriteria_id')->on('table_kriteria');
        });

        Schema::create('table_periode', function (Blueprint $table) {
            $table->id('periode_id');
            $table->string('nama_periode');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });

        Schema::create('table_rekomendasi', function (Blueprint $table) {
            $table->id('rekomendasi_id');
            $table->unsignedBigInteger('alternatif_id');
            $table->float('nilai_akhir');
            $table->integer('ranking');
            $table->unsignedBigInteger('periode_id');
            $table->timestamps();

            $table->foreign('alternatif_id')->references('alternatif_id')->on('table_alternatif');
            $table->foreign('periode_id')->references('periode_id')->on('table_periode');

            $table->unique(['alternatif_id', 'periode_id']);
        });

        Schema::create('table_UmpanBalik', function (Blueprint $table) {
            $table->id('UmpanBalik_id');
            $table->unsignedBigInteger('rekomendasi_id');
            $table->string('no_induk', 20);
            $table->text('komentar')->nullable();
            $table->integer('skala_kepuasan');
            $table->timestamps();

            $table->foreign('rekomendasi_id')->references('rekomendasi_id')->on('table_rekomendasi');
            $table->foreign('no_induk')->references('no_induk')->on('table_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_level');
        Schema::dropIfExists('table_jurusan');
        Schema::dropIfExists('table_prodi');
        Schema::dropIfExists('table_users');
        Schema::dropIfExists('table_laporan');
        Schema::dropIfExists('table_gedung');
        Schema::dropIfExists('table_lantai');
        Schema::dropIfExists('table_ruangan');
        Schema::dropIfExists('table_fasilitas');
        Schema::dropIfExists('table_kriteria');
        Schema::dropIfExists('table_alternatif');
        Schema::dropIfExists('table_penilaian');
        Schema::dropIfExists('table_periode');
        Schema::dropIfExists('table_rekomendasi');
        Schema::dropIfExists('table_UmpanBalik');
    }
};
