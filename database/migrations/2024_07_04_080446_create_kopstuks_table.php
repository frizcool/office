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
        Schema::create('kopstuks', function (Blueprint $table) {
            $table->id();   
            $table->string('ur_kopstuk');
            $table->string('kd_ktm');
            $table->string('kd_smk');
            $table->timestamps();

        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kopstuks');
    }
};
