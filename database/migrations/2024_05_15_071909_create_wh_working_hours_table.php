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
        Schema::create('wh_working_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wh_id');
            $table->foreign('wh_id')->references('id')->on('ware_houses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('from_wh_id')->nullable()->default(null);
            $table->foreign('from_wh_id')->references('id')->on('operational_hours')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('to_wh_id')->nullable()->default(null);
            $table->foreign('to_wh_id')->references('id')->on('operational_hours')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('is_open',['1','2'])->comment('1 open 2 close');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_working_hours');
    }
};
