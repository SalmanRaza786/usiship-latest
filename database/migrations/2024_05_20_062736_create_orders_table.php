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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('wh_id');
            $table->foreign('wh_id')->references('id')->on('ware_houses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('dock_id');
            $table->foreign('dock_id')->references('id')->on('wh_docks')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('operational_hour_id');
            $table->foreign('operational_hour_id')->references('id')->on('operational_hours')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('order_type',[1,2])->comment('1 Inbound,2 outbound');
            $table->enum('status',[1,2,3,4,5,6])->comment('1 accepted,2 rejected,3 in process,4 delivered,5 received,6 requested');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
