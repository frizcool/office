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
        Schema::table('surat_keluars', function (Blueprint $table) {
            $table->uuid('lemari_id')->nullable()->after('status');
            $table->uuid('loker_id')->nullable()->after('lemari_id');
            $table->uuid('rak_id')->nullable()->after('loker_id');

            $table->foreign('lemari_id')->references('id')->on('lemaris')->onDelete('set null');
            $table->foreign('loker_id')->references('id')->on('lokers')->onDelete('set null');
            $table->foreign('rak_id')->references('id')->on('raks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_keluars', function (Blueprint $table) {
            $table->dropForeign(['lemari_id']);
            $table->dropForeign(['loker_id']);
            $table->dropForeign(['rak_id']);
            $table->dropColumn('lemari_id');
            $table->dropColumn('loker_id');
            $table->dropColumn('rak_id');
        });
    }
};
