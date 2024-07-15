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
        Schema::create('surat_masuks', function (Blueprint $table) {            
            $table->uuid('id')->primary();
            $table->string('nomor_agenda');
            $table->string('terima_dari');
            $table->string('nomor_surat');
            $table->date('tanggal_agenda');
            $table->string('waktu_agenda');
            $table->date('tanggal_surat');
            $table->string('kd_ktm');
            $table->string('kd_smk');
            $table->text('perihal');
            $table->Integer('klasifikasi_id')->constrained('klasifikasi_surats')->onDelete('cascade');
            $table->Integer('status_id')->constrained('statuses')->onDelete('cascade');
            $table->Integer('sifat_id')->constrained('sifats')->onDelete('cascade');
            $table->string('lampiran_surat_masuk');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
