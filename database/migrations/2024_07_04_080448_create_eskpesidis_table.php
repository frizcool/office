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
        Schema::create('eskpesidis', function (Blueprint $table) {
            $table->id();
            $table->string('kd_ktm');
            $table->string('kd_smk');
            $table->string('surat_keluar_id');
            $table->date('tanggal_distribusi');
            $table->string('penerima');
            $table->date('tanggal_diterima');
            $table->string('paraf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eskpesidis');
    }
};
