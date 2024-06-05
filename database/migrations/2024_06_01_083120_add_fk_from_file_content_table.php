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
            $table->unsignedBigInteger('form_id')->nullable()->default(null)->after('fileable_type');
            $table->foreign('form_id')->references('id')->on('order_forms')->onDelete('cascade')->onUpdate('cascade');
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
