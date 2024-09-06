<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $data_tim_teknis = [

            'Sistem Informasi dan Humas',
            'Perpustakaan, Ketatausahaan dan Kearsipan',
            'Perencanaan',
            'Keuangan dan BMN',
            'Perlengkapan dan Kerumahtanggaan',
            'Hukum dan Kerjasama',
            'Ortala dan Kepegawaian',
            'Pemetaan Sistematik',
            'Pemetaan Tematik',
            'Survei Umum Migas',
            'Rekomendasi Wilayah Keprospekan Migas',
            'Geopark Nasional dan Pusat Informasi Geologi',
            'Warisan Geologi',
            'Pengembangan Konsep Geosains',
            
        ];

        Schema::create('dokumen', function (Blueprint $table) use ($data_tim_teknis) {
            $table->uuid('id')->primary();
            $table->string('nomor_surat')->unique();
            $table->enum('tim_teknis',$data_tim_teknis);
            $table->date('tanggal_awal_dinas');
            $table->date('tanggal_akhir_dinas');
            $table->integer('sisa_hari')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
