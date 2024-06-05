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
        Schema::table('order_forms', function (Blueprint $table) {
            $table->enum('is_file',[1,2])->default(2)->comment('1 mean file 2 mean text filed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_forms', function (Blueprint $table) {
            //
        });
    }
};
