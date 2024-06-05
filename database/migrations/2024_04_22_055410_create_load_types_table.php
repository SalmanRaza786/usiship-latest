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
        Schema::create('load_types', function (Blueprint $table) {
            $table->id();
            $table->string('direction');
            $table->string('operation');
            $table->string('equipment_type');
            $table->string('trans_mode');
            $table->enum('status',[1,2])->comment('1 active, 2 inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('load_types');
    }
};
