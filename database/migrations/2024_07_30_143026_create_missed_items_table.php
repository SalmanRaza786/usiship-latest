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
        Schema::create('missed_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('status_code');
            $table->foreign('status_code')->references('order_by')->on('order_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('start_time')->nullable()->default(null);
            $table->dateTime('end_time')->nullable()->default(null);;
            $table->unsignedBigInteger('auth_id');
            $table->foreign('auth_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missed_items');
    }
};
