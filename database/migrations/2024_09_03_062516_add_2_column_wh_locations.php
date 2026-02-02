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
        Schema::table('wh_locations', function (Blueprint $table) {
            $table->integer('wms_location_id')->nullable()->default(null);
            $table->integer('wms_warehouse_id')->nullable()->default(null);
            $table->string('type')->nullable()->default(null);
            $table->timestampTz('wms_updated_date')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wh_locations', function (Blueprint $table) {
           $table->dropColumn('wms_location_id');
           $table->dropColumn('wms_warehouse_id');
           $table->dropColumn('type');
           $table->dropColumn('wms_updated_date');
        });
    }
};
