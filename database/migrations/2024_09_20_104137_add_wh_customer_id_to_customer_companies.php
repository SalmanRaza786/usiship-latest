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
        Schema::table('customer_companies', function (Blueprint $table) {
            $table->string('wms_customer_id')->nullable()->default(null)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_companies', function (Blueprint $table) {
           $table->dropColumn('wms_customer_id');
        });
    }
};
