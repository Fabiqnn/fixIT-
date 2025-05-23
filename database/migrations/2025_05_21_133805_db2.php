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

        Schema::table('fasilitas', function (Blueprint $table) { 
            $table->dropForeign(['table_fasilitas_gedung_id_unique']);
            $table->dropColumn('gedung_id');

            $table->unsignedBigInteger('id_ruangan')->nullable();
            $table->foreign('ruangan_id')->references('id_ruangan')->on('table_ruangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
