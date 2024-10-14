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
        Schema::create('menu_group', function (Blueprint $table) {
            $table->id('id_menu_group');
            $table->string('nama_menu_group');
            $table->string('icon_menu_group');
            $table->unsignedBigInteger('id_permission_menu_group');
            $table->timestamps();
            $table->foreign('id_permission_menu_group')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_group');
    }
};