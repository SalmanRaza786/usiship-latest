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
        Schema::table('order_processings', function (Blueprint $table) {
            $table->integer('carton_label_req')->nullable()->default(null);
            $table->integer('pallet_label_req')->nullable()->default(null);
            $table->text('other_require')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_processings', function (Blueprint $table) {
            $table->dropColumn('carton_label_req');
            $table->dropColumn('pallet_label_req');
            $table->dropColumn('other_require');
        });
    }
};
