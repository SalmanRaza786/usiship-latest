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
            $table->string('container_number')->after('status_id')->nullable()->default(null);
            $table->string('seal')->after('container_number')->nullable()->default(null);

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
