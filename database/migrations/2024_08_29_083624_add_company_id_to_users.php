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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->after('id')->nullable()->default(null);
            $table->foreign('company_id')->references('id')->on('customer_companies')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status',[1,2])->comment('1 active, 2 inactive')->nullable()->default(2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('company_id');
            $table->dropColumn('status');
        });
    }
};
