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
        Schema::table('order_off_loadings', function (Blueprint $table) {
            $table->string('start_time')->nullable()->default(null);
            $table->string('end_time')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_off_loadings', function (Blueprint $table) {
            //
        });
    }
};
