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
        Schema::create('docks_load_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dock_id');
            $table->foreign('dock_id')->references('id')->on('wh_docks')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('load_type_id');
            $table->foreign('load_type_id')->references('id')->on('load_types')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docks_load_types');
    }
};
