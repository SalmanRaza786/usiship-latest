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
        Schema::table('work_order_pickers', function (Blueprint $table) {
            $table->dropForeign('work_order_pickers_status_id_foreign');
            $table->dropColumn('status_id');
        });

        Schema::table('work_order_pickers', function (Blueprint $table) {
            $table->unsignedBigInteger('status_code')->nullable()->default(null);
            $table->foreign('status_code')->references('order_by')->on('order_statuses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_pickers', function (Blueprint $table) {
            //
        });
    }
};
