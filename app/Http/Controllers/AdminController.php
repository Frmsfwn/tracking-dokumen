<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\TrackingDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // Sisa Hari
        $dokumen = new Dokumen();

        $dokumen->tim_teknis = $request->input('tim_teknis');
        $dokumen->nomor_surat = $request->input('nomor_surat_tugas');
        $dokumen->tanggal_awal_dinas = $request->input('tanggal_awal_dinas');
        $dokumen->tanggal_akhir_dinas = $request->input('tanggal_akhir_dinas');

        // Penghitungan sisa hari
        $dokumen->hitungSisaHari();

        $id_dokumen = Dokumen::find($dokumen->id)->id;

        $data_tracking = [
            [
                'id_dokumen' => $id_dokumen,
                'id_admin' => Auth::id(),
                'status_dokumen' => 'Pengajuan Nota Dinas',
                'opsi' => 'setuju',
            ],[
                'id_dokumen' => $id_dokumen,
                'status_dokumen' => 'Penerbitan Surat Dinas',
            ],[
                'id_dokumen' => $id_dokumen,
                'status_dokumen' => 'Pembuatan Rampung',
            ],[
                'id_dokumen' => $id_dokumen,
                'status_dokumen' => 'Penandatanganan Rampung',
            ],[
                'id_dokumen' => $id_dokumen,
                'status_dokumen' => 'Penandatanganan PPK',
            ],[
                'id_dokumen' => $id_dokumen,
                'status_dokumen' => 'Penandatanganan Kabag Umum',
            ],[
                'id_dokumen' => $id_dokumen,
                'status_dokumen' => 'Proses SPBY',
            ],[
                'id_dokumen' => $id_dokumen,
                'status_dokumen' => 'Proses Transfer',
            ]
        ];

        foreach($data_tracking as $dataTracking)
        {
            TrackingDokumen::create($dataTracking);
        }

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil ditambahkan.');

        return redirect(route('admin.status.dokumen', ['id' => $id_dokumen]));
    }

    function statusDokumen($id)
    {

        $data_dokumen = Dokumen::find($id);
        $customOrder = [            
            'Pengajuan Nota Dinas',
            'Penerbitan Surat Dinas',
            'Pembuatan Rampung',
            'Penandatanganan Rampung',
            'Penandatanganan PPK',
            'Penandatanganan Kabag Umum',
            'Proses SPBY',
            'Proses Transfer',
        ];
        $data_tracking = 
            $data_dokumen->tracking->sort(function ($a, $b) use ($customOrder) {
                $aIndex = array_search($a['status_dokumen'], $customOrder);
                $bIndex = array_search($b['status_dokumen'], $customOrder);
                
                // Handle case where item might not be found in the customOrder array
                if ($aIndex === false) $aIndex = PHP_INT_MAX;
                if ($bIndex === false) $bIndex = PHP_INT_MAX;
                
                return $aIndex <=> $bIndex;
            });

        return view('Admin.ubahStatus')
            ->with('data_dokumen',$data_dokumen)
            ->with('data_tracking',$data_tracking);

    }

    function updateStatus(Dokumen $Dokumen,Request $request)
    {

        $id_tracking = $request->id_tracking;
        $catatan = $request->input($id_tracking);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Error!</b><br>Data gagal disimpan.');

        Validator::make($request->input(), [

            'opsi' => 'required|in:setuju,perbaiki',
            'catatan' => 'nullable',

        ])->validateWithBag($id_tracking);

        $tracking = TrackingDokumen::find($id_tracking);
        $tracking->update([

            'id_admin' => Auth::id(),
            'opsi' => $request->opsi,
            'catatan' => $catatan,

        ]);

        $Dokumen->updated_at = now();
        $Dokumen->save();

        if($tracking->status_dokumen === 'Proses Transfer') {

            if($tracking->opsi === 'setuju') {

                $Dokumen->update([
                    'status' => 'selesai',
                    'sisa_hari' => null,
                ]);

            }
        }

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil disimpan.');

        return redirect(route('admin.status.dokumen', ['id' => $Dokumen->id]));
    }
    
}