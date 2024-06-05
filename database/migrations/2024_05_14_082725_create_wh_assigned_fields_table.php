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
        Schema::create('wh_assigned_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wh_id');
            $table->foreign('wh_id')->references('id')->on('ware_houses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')->references('id')->on('custom_fields')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['1', '2'])->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wh_assigned_fields');
    }
};
