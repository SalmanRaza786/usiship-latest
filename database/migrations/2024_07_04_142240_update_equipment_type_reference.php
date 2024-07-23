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
            $table->dropForeign('load_types_equipment_type_id_foreign');
            $table->dropForeign('load_types_operation_id_foreign');
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
