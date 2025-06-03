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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_kriteria');
        Schema::dropIfExists('table_alternatif');
        Schema::dropIfExists('table_penilaian');
    }
};
