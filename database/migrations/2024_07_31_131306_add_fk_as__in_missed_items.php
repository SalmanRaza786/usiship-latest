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
        Schema::table('missed_items', function (Blueprint $table) {
            $table->unsignedBigInteger('picker_table_id')->after('id');
            $table->foreign('picker_table_id')->references('id')->on('work_order_pickers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('missed_items', function (Blueprint $table) {
            //
        });
    }
};
