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
        Schema::table('order_contacts', function (Blueprint $table) {
            $table->string('vehicle_class')->nullable()->default(null);
            $table->string('other_vehicle_class')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_contacts', function (Blueprint $table) {
            $table->dropColumn('vehicle_class');
            $table->dropColumn('other_vehicle_class');
        });
    }
};
