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
        Schema::create('resolved_missed_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('missed_detail_parent_id');
            $table->foreign('missed_detail_parent_id')->references('id')->on('missed_item_details')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('new_loc_id');
            $table->foreign('new_loc_id')->references('id')->on('wh_locations')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('resolve_qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resolved_missed_items');
    }
};
