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

        Schema::table('order_statuses', function (Blueprint $table) {
            $table->index('order_by');
        });

        Schema::table('work_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('status_code')->nullable()->default(null);
            $table->foreign('status_code')->references('order_by')->on('order_statuses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            //
        });
    }
};
