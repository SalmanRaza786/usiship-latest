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
            $table->unsignedBigInteger('status_id')->nullable()->default(null);;
            $table->foreign('status_id')->references('id')->on('order_statuses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_contacts', function (Blueprint $table) {
            $table->dropForeign('order_contacts_status_id_foreign');
        });
    }
};
