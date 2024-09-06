<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    
    function createDokumen()
    {

        return view('Admin.DokumenBaru');

    }

    function storeDokumen(Request $request)
    {
        $messages = [

            'nomor_surat_tugas.required' => 'Nomor Surat Tugas tidak dapat kosong.',
            'nomor_surat_tugas.max' => 'Nomor Surat Tugas maksimal berisi 25 karakter.',
            'nomor_surat_tugas.unique' => 'Nomor Surat Tugas telah ditambahkan pada database.',
            'nomor_surat_tugas.regex' => 'Nomor Surat Tugas tidak valid.',
            'tim_teknis.required' => 'Urusan/Tim Teknis tidak dapat kosong.',
            'tim_teknis.in' => 'Urusan/Tim Teknis tidak valid.',
            'tanggal_awal_dinas.required' => 'Tanggal Awal Dinas tidak dapat kosong.',
            'tanggal_awal_dinas.date' => 'Tanggal Awal Dinas tidak valid.',
            'tanggal_akhir_dinas.required' => 'Tanggal Akhir Dinas tidak dapat kosong.',
            'tanggal_akhir_dinas.date' => 'Tanggal Akhir Dinas tidak valid.',
            'tanggal_akhir_dinas.after' => 'Tanggal Akhir Dinas tidak valid.',
        
        ];

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

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Data gagal ditambahkan.');

        Validator::make($request->input(), [

            'nomor_surat_tugas' => ['required','max:25','unique:dokumen,nomor_surat','regex:/^[A-Z0-9\/-]+$/'],
            'tim_teknis' => ['required',Rule::in($data_tim_teknis)],
            'tanggal_awal_dinas' => 'required|date',
            'tanggal_akhir_dinas' => 'required|date|after:tanggal_awal_dinas',

        ],$messages)->validateWithBag('tambah_data');

        $inputeddata = [

            'nomor_surat' => $request->input('nomor_surat_tugas'),
            'tim_teknis' => $request->input('tim_teknis'),
            'tanggal_awal_dinas' => $request->input('tanggal_awal_dinas'),
            'tanggal_akhir_dinas' => $request->input('tanggal_akhir_dinas'),

        ];

        Dokumen::create($inputeddata);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil ditambahkan.');

        return redirect(route('admin.homepage'));
    }

    function statusDokumen()
    {

        return view('Admin.ubahStatus');

    }
    
}
