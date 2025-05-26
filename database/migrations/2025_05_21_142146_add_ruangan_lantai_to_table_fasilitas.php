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
            $table->unsignedBigInteger('lantai_id')->nullable()->after('ruangan_id');

            // Foreign key constraint
            $table->foreign('ruangan_id')
                ->references('id_ruangan')->on('table_ruangan')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('lantai_id')
                ->references('id_lantai')->on('table_lantai')
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
            $table->dropForeign(['lantai_id']);

            // Hapus kolom
            $table->dropColumn(['ruangan_id', 'lantai_id']);
        });
    }
};
