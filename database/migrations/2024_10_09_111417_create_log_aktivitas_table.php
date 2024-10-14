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
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->dateTime('datetime_log')->useCurrent();
            $table->integer('userId_log')->nullable();
            $table->string('keterangan_log');
            $table->string('endpoint_log');
            $table->json('data_awal');
            $table->json('data_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};