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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('ship_method');
            $table->date('order_date');
            $table->date('ship_date');
            $table->unsignedBigInteger('load_type_id')->nullable()->default(null);
            $table->foreign('load_type_id')->references('id')->on('load_types')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('carrier_id')->nullable()->default(null);;
            $table->foreign('carrier_id')->references('id')->on('load_types')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('order_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
