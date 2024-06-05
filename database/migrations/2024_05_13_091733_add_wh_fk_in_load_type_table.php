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
        Schema::table('load_types', function (Blueprint $table) {
            $table->unsignedBigInteger('wh_id')->nullable()->default(null)->after('id');
            $table->foreign('wh_id')->references('id')->on('ware_houses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('load_types', function (Blueprint $table) {
            //
        });
    }
};
