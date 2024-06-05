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
            $table->enum('is_verify',[0,1])->default(0)->comment('0 mean not verify 1 mean verify');
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
