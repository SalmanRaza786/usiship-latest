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
        Schema::create('qc_detail_work_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qc_parent_id');
            $table->foreign('qc_parent_id')->references('id')->on('qc_work_orders')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('w_order_item_id');
            $table->foreign('w_order_item_id')->references('id')->on('work_order_items')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('picked_qty');
            $table->unsignedBigInteger('qc_picked_qty')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qc_detail_work_orders');
    }
};
