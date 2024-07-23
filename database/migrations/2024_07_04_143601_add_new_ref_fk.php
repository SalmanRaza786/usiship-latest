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

            $table->foreign('operation_id')->references('id')->on('l_t_operations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('equipment_type_id')->references('id')->on('l_t_equipment_types')->onDelete('cascade')->onUpdate('cascade');
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
