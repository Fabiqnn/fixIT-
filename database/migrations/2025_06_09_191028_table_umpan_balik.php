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
        Schema::dropIfExists('table_UmpanBalik');
    }
};
