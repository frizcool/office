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
        Schema::create('lemaris', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_lemari');
            $table->timestamps();
        });

        Schema::create('lokers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_loker');
            $table->timestamps();
        });

        Schema::create('raks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_rak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lemaris');
        Schema::dropIfExists('lokers');
        Schema::dropIfExists('raks');
    }
};
