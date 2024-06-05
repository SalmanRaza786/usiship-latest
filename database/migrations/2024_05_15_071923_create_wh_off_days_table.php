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
        Schema::create('wh_off_days', function (Blueprint $table) {
            $table->id();
            $table->foreign('wh_id')->references('id')->on('ware_houses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('wh_id');
            $table->date('close_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_off_days');
    }
};
