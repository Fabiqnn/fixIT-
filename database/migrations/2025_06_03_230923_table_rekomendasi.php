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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_rekomendasi');
        Schema::dropIfExists('table_periode');
    }
};
