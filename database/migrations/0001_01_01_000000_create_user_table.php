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

        Schema::create('user', function (Blueprint $table) use ($data_tim_teknis){
            $table->uuid('id')->primary();
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role',['SuperAdmin','Admin','PIC']);
            $table->enum('tim_teknis',$data_tim_teknis)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
        Schema::dropIfExists('sessions');
    }
};
