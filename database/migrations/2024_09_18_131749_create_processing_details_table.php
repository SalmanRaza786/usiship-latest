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
        Schema::create('processing_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('processing_id');
            $table->foreign('processing_id')->references('id')->on('order_processings')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('work_order_id');
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('task_id')->nullable()->default(null);
            $table->unsignedBigInteger('qty')->nullable()->default(null);
            $table->text('comment')->nullable()->default(null);
            $table->unsignedBigInteger('status_code');
            $table->foreign('status_code')->references('order_by')->on('order_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('auth_id');
            $table->foreign('auth_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing_details');
    }
};
