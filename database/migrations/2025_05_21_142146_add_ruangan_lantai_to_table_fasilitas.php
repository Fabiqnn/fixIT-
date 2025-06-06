<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('table_fasilitas', function (Blueprint $table) {
            // Tambah kolom baru
            $table->unsignedBigInteger('ruangan_id')->nullable();

            // Foreign key constraint
            $table->foreign('ruangan_id')
                ->references('id_ruangan')->on('table_ruangan')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('table_fasilitas', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['ruangan_id']);

            // Hapus kolom
            $table->dropColumn(['ruangan_id', 'lantai_id']);
        });
    }
};
