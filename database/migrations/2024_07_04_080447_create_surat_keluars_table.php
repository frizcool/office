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
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_agenda');
            $table->date('tanggal_agenda');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('kepada');
            $table->string('perihal');
            $table->string('kd_ktm');
            $table->string('kd_smk');
            $table->string('status');
            $table->Integer('klasifikasi_id')->constrained('klasifikasi_surats')->onDelete('cascade');
            $table->string('lokasi_fisik')->nullable();
            $table->string('lampiran_surat_keluar');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
