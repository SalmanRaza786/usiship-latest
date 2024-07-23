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
        Schema::table('order_check_ins', function (Blueprint $table) {
            $table->unsignedBigInteger('door_id')->nullable()->default(null);
            $table->foreign('door_id')->references('id')->on('wh_doors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_check_ins', function (Blueprint $table) {
            $table->dropForeign('order_check_ins_door_id_foreign');
        });
    }
};
