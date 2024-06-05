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
        Schema::table('file_contents', function (Blueprint $table) {
            $table->dropForeign('file_contents_form_field_id_foreign');
            $table->dropColumn('form_field_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_contents', function (Blueprint $table) {
            //
        });
    }
};
