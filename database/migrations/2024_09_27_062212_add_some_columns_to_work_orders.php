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
            $table->string('wms_order_status')->nullable()->default(null);
            $table->timestamp('wms_created_at')->nullable()->default(null);
            $table->timestamp('wms_updated_at')->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
           $table->dropColumn('wms_order_status');
           $table->dropColumn('wms_created_at');
           $table->dropColumn('wms_updated_at');
        });
    }
};
