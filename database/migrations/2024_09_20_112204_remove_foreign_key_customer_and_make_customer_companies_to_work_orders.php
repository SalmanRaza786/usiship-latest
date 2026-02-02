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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropForeign('work_orders_client_id_foreign');
            $table->dropColumn('client_id');
        });
        Schema::table('work_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->default(null)->after('id');
            $table->foreign('client_id')->references('id')->on('customer_companies')->onDelete('cascade')->onUpdate('cascade');
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
