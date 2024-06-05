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
        Schema::table('ware_houses', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('wh_operation_hours', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('load_types', function (Blueprint $table) {
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ware_houses', function (Blueprint $table) {
            //
        });
    }
};
