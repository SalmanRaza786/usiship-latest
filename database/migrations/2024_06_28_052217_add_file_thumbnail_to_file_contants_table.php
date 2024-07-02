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
            $table->string('file_thumbnail')->nullable()->default(null)->after('file_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_contents', function (Blueprint $table) {
            $table->dropColumn('file_thumbnail');
        });
    }
};
