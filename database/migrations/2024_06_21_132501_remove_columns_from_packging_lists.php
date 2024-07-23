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
        Schema::table('packging_lists', function (Blueprint $table) {
            $table->dropColumn(['recv_qty', 'remarks', 'damage', 'upc_label_photo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packging_lists', function (Blueprint $table) {
            $table->integer('recv_qty')->nullable()->default(null);
            $table->text('remarks')->nullable()->default(null);
            $table->integer('damage')->nullable()->default(null);
            $table->string('upc_label_photo')->nullable()->default(null);
        });
    }
};
