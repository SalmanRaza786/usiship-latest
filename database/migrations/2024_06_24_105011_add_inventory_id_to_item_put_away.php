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
        Schema::table('order_item_put_aways', function (Blueprint $table) {
            $table->dropColumn('sku');
        });

        Schema::table('order_item_put_aways', function (Blueprint $table) {
            $table->unsignedBigInteger('inventory_id')->after('order_id');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     ;
    }
};
