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
        Schema::create('wh_operation_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wh_id');
            $table->foreign('wh_id')->references('id')->on('ware_houses')->onDelete('cascade')->onUpdate('cascade');
            $table->string('day_name');
            $table->time('wh_from');
            $table->time('wh_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_operation_hours');
    }
};
