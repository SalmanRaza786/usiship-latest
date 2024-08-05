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
        Schema::table('work_order_pickers', function (Blueprint $table) {
            $table->dropForeign('work_order_pickers_picker_id_foreign');
            $table->dropColumn('picker_id');
        });

        Schema::table('work_order_pickers', function (Blueprint $table) {
            $table->unsignedBigInteger('picker_id')->nullable();
            $table->foreign('picker_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_pickers', function (Blueprint $table) {
            //
        });
    }
};
