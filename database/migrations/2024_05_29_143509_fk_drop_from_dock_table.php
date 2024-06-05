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

        Schema::table('wh_docks', function (Blueprint $table) {
            $table->dropForeign('wh_docks_load_type_id_foreign');
            $table->dropColumn('load_type_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wh_docks', function (Blueprint $table) {
            //
        });
    }
};
