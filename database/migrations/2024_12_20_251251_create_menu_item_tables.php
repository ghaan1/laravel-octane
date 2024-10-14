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
        Schema::create('menu_item', function (Blueprint $table) {
            $table->id('id_menu_item');
            $table->string('nama_menu_item');
            $table->unsignedBigInteger('id_menu_group');
            $table->unsignedBigInteger('id_permission_menu_item')->nullable();
            $table->json('list_permission_menu_item')->nullable();
            $table->timestamps();
            $table->foreign('id_menu_group')->references('id_menu_group')->on('menu_group')->restrictOnDelete();
            $table->foreign('id_permission_menu_item')->references('id')->on('permissions')->cascadeOnDelete()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item');
    }
};