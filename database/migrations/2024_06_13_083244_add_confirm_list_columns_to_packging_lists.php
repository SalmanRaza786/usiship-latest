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
            $table->integer('qty_received_cartons')->nullable()->default(null);
            $table->integer('qty_received_each')->nullable()->default(null);
            $table->integer('exception_qty')->nullable()->default(null);
            $table->integer('damage')->nullable()->default(null);
            $table->integer('total_pallets')->nullable()->default(null);
            $table->string('lot_3')->nullable()->default(null);
            $table->string('serial_number')->nullable()->default(null);
            $table->string('upc_label')->nullable()->default(null);
            $table->string('upc_label_photo')->nullable()->default(null);
            $table->date('expiry_date')->nullable()->default(null);
            $table->decimal('length', 8, 2)->nullable()->default(null);
            $table->decimal('width', 8, 2)->nullable()->default(null);
            $table->decimal('height', 8, 2)->nullable()->default(null);
            $table->decimal('weight', 8, 2)->nullable()->default(null);
            $table->string('custom_field_1')->nullable()->default(null);
            $table->string('custom_field_2')->nullable()->default(null);
            $table->string('custom_field_3')->nullable()->default(null);
            $table->string('custom_field_4')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packging_lists', function (Blueprint $table) {
            //
        });
    }
};
