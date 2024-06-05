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
        Schema::table('order_contacts', function (Blueprint $table) {
            $table->string('vehicle_number')->nullable()->default(null);
            $table->string('vehicle_licence_plate')->nullable()->default(null);
            $table->string('bol_number')->nullable()->default(null);
            $table->string('do_number')->nullable()->default(null);
            $table->string('do_document')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_contacts', function (Blueprint $table) {
            //
        });
    }
};
