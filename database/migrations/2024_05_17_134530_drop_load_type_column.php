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
            $table->dropColumn('direction');
            $table->dropColumn('operation');
            $table->dropColumn('equipment_type');
            $table->dropColumn('trans_mode');

            $table->unsignedBigInteger('direction_id')->after('status');
            $table->foreign('direction_id')->references('id')->on('l_t_directions')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('operation_id')->after('direction_id');;
            $table->foreign('operation_id')->references('id')->on('l_t_equipment_types')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('equipment_type_id')->after('operation_id');;
            $table->foreign('equipment_type_id')->references('id')->on('l_t_operations')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('trans_mode_id')->after('equipment_type_id');;
            $table->foreign('trans_mode_id')->references('id')->on('l_t_transportaion_modes')->onDelete('cascade')->onUpdate('cascade');

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
