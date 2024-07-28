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
        Schema::create('disposisi_surat_keluars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('surat_keluar_id');
            $table->string('status'); // draft, in_review, approved
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->string('user_id')->nullable();
            $table->timestamps();            
            $table->foreign('surat_keluar_id')->references('id')->on('surat_keluars')->onDelete('cascade');            
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi_surat_keluars');
    }
};
