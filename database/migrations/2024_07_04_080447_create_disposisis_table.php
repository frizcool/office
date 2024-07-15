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
        Schema::create('disposisis', function (Blueprint $table) {           
            $table->uuid('id')->primary();
            $table->uuid('surat_masuk_id')->constrained('surat_masuks')->onDelete('cascade');
            $table->string('disposisi_kepada');
            $table->text('isi')->nullable();
            $table->text('catatan')->nullable();
            $table->text('paraf')->nullable();
            $table->date('tanggal_disposisi');
            $table->integer('user_id')->constrained('users')->onDelete('cascade');
            $table->string('disposisi_list_id')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisis');
    }
};
