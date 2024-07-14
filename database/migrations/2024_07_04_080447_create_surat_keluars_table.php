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
            $table->id();
            $table->string('nomor_agenda');
            $table->date('tanggal_masuk');
            $table->string('kepada');
            $table->string('perihal');
            $table->foreignId('klasifikasi_id')->constrained('klasifikasi_surats')->onDelete('cascade');
            $table->string('lokasi_fisik');
            $table->string('lampiran_surat_masuk');
            $table->string('status');
            $table->timestamps();
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
