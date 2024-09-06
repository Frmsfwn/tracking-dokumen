<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $data_status = [            
            'Pengajuan Nota Dinas',
            'Penerbitan Surat Dinas',
            'Pembuatan Rampung',
            'Penandatanganan Rampung',
            'Penandatanganan PPK',
            'Penandatanganan Kabag Umum',
            'Proses SPBY',
            'Proses Transfer',
        ];

        Schema::create('tracking_dokumen', function (Blueprint $table) use ($data_status) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_dokumen')->references('id')->on('dokumen')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('id_admin')->nullable()->references('id')->on('user')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status_dokumen',$data_status);
            $table->enum('opsi',['setuju','perbaiki'])->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_dokumen');
    }
};
