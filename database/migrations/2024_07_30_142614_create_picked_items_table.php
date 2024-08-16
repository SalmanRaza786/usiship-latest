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
        Schema::create('picked_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('picker_table_id');
            $table->foreign('picker_table_id')->references('id')->on('work_order_pickers')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('inventory_id');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('loc_id');
            $table->foreign('loc_id')->references('id')->on('wh_locations')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('order_qty');
            $table->unsignedBigInteger('picked_loc_id')->nullable()->default(null);
            $table->foreign('picked_loc_id')->references('id')->on('wh_locations')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('picked_qty')->nullable()->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picked_items');
    }
};
