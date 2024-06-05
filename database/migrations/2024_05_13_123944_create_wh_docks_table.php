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
        Schema::create('wh_docks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wh_id');
            $table->foreign('wh_id')->references('id')->on('ware_houses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('load_type_id');
            $table->foreign('load_type_id')->references('id')->on('load_types')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->string('slot');
            $table->string('cancel_before');
            $table->string('schedule_limit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_docks');
    }
};
