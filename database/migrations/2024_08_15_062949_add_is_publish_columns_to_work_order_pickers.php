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
            $table->enum('is_publish',[1,2])->default(1)->comment('1 mean published 2 mean un publish');
        });
        Schema::table('qc_work_orders', function (Blueprint $table) {
            $table->enum('is_publish',[1,2])->default(1)->comment('1 mean published 2 mean un publish');
        });
        Schema::table('missed_items', function (Blueprint $table) {
            $table->enum('is_publish',[1,2])->default(1)->comment('1 mean published 2 mean un publish');
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
