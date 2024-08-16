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
        Schema::create('missed_item_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('missed_items_parent_id');
            $table->foreign('missed_items_parent_id')->references('id')->on('missed_items')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('picked_item_table_id');
            $table->foreign('picked_item_table_id')->references('id')->on('picked_items')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('inventory_id');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('missed_qty')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missed_item_details');
    }
};
