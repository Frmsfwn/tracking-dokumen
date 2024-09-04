<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_dokumen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_dokumen')->references('id')->on('dokumen')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('pengajuan_nota_dinas')->nullable();
            $table->string('penerbitan_surat_dinas')->nullable();
            $table->string('pembuatan_rampung')->nullable();
            $table->string('penandatanganan_rampung')->nullable();
            $table->string('penandatanganan_ppk')->nullable();
            $table->string('penandatanganan_kabag_umum')->nullable();
            $table->string('proses_spby')->nullable();
            $table->string('proses_transfer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_dokumen');
    }
};
