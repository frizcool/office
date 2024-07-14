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
        Schema::create('satminkals', function (Blueprint $table) {
            $table->id();
            $table->string('kd_ktm');
            $table->string('kd_smk');
            $table->string('ur_smk');
            $table->timestamps();
            $table->foreign('kd_ktm')->references('kd_ktm')->on('kotamas')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satminkals');
    }
};
