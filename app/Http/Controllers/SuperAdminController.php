<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\TrackingDokumen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    function dataUser(Request $request)
    {
        $keyword = $request->input('keyword');
        $filter = $request->input('filter', 'all');
    
        $data = User::whereNot('role', 'SuperAdmin');
            
        if ($keyword) {
            $data->whereAny(['nip','nama','role','tim_teknis'], 'LIKE', "%{$keyword}%")
            ->orderBy('updated_at', 'DESC')
            ->paginate(8);
        }
    
        if ($filter) {
            if ($filter == 'admin') {
                $data->where('role', 'Admin');
            } elseif ($filter == 'pic') {
                $data->where('role', 'PIC');
            }
        }
        $data_user = $data->orderBy('updated_at', 'DESC')->paginate(8);
        
        return view('SuperAdmin.dataUser')
            ->with('data_user',$data_user)
            ->with('filter',$filter);
    }

    function createUser(Request $request)
    {

        $messages = [

            'nip_user.required' => 'NIP tidak dapat kosong.',
            'nip_user.max_digits' => 'NIP maksimal 25 angka.',
            'nip_user.numeric' => 'NIP tidak valid.',
            'nip_user.unique' => 'NIP telah ditambahkan pada database.',
            'nama_user.required' => 'Nama tidak dapat kosong.',
            'nama_user.max' => 'Nama maksimal 25 karakter.',
            'username.required' => 'Username tidak dapat kosong.',
            'username.max:25' => 'Username maksimal 25 karakter.',
            'username.unique' => 'Username telah ditambahkan pada database.',
            'password.min' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password.max' => 'Password maksimal berisi 16 terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password.regex' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password.required' => 'Password tidak dapat kosong.',
            'role.required' => 'Role tidak dapat kosong.',
            'role.in' => 'Role tidak valid.',
            'tim_teknis.required' => 'Tim Teknis tidak dapat kosong.',
            'tim_teknis.in' => 'Tim Teknis tidak valid.',
        
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

            'nip_user' => 'required|max_digits:25|numeric|unique:user,nip',
            'nama_user' => 'required|max:25',
            'username' => 'required|max:25|unique:user,username',
            'password' => ['required','min:8','max:16','regex:/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/'],
            'role' => 'required|in:SuperAdmin,Admin,PIC',
            'tim_teknis' => ['required_if:role,PIC', Rule::in($data_tim_teknis)],

        ],$messages)->validateWithBag('tambah_data');

        $inputeddata = [

            'nip' => $request->input('nip_user'),
            'nama' => $request->input('nama_user'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'tim_teknis' => $request->input('role') == 'PIC' ? $request->input('tim_teknis') : null,

        ];

        User::create($inputeddata);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil ditambahkan.');
        
        return redirect(route('superAdmin.show.user'));

    }

    function updateUser(User $User, Request $request)
    {
        $messages = [
            
            'nip_user.required' => 'NIP tidak dapat kosong.',
            'nip_user.max_digits' => 'NIP maksimal 25 angka.',
            'nip_user.numeric' => 'NIP tidak valid.',
            'nip_user.unique' => 'NIP telah ditambahkan pada database.',
            'nama_user.required' => 'Nama tidak dapat kosong.',
            'nama_user.max' => 'Nama maksimal 25 karakter.',
            'username.required' => 'Username tidak dapat kosong.',
            'username.max:25' => 'Username maksimal 25 karakter.',
            'username.unique' => 'Username telah ditambahkan pada databsse.',
            'password.min' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password.max' => 'Password maksimal berisi 16 terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password.regex' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password.required' => 'Password tidak dapat kosong.',

        ];

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->error('<b>Kesalahan!</b><br>Data gagal diubah.');

        Validator::make($request->input(), [

            'nip_user' => ['required','max_digits:25','numeric',Rule::unique('user','nip')->ignore($User->id)],
            'nama_user' => 'required|max:25',
            'username' => ['required','max:25',Rule::unique('user','username')->ignore($User->id)],
            'password' => ['required','min:8','max:16','regex:/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/'],

        ],$messages)->validateWithBag($User->id);

        $User->update([

            'nip' => $request->input('nip_user'),
            'nama' => $request->input('nama_user'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            
        ]);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil diubah.');

        return redirect(route('superAdmin.show.user'));

    }

    function deleteUser(User $User)
    {

        User::destroy($User->id);

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil dihapus.');

        return redirect(route('superAdmin.show.user'));

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

        return view('superAdmin.ubahStatus')
            ->with('data_dokumen',$data_dokumen)
            ->with('data_tracking',$data_tracking);

    }

    function deleteDokumen(Dokumen $Dokumen)
    {

        $tracking_dokumen = TrackingDokumen::where('id_dokumen',$Dokumen->id)->get();

        Dokumen::destroy($Dokumen->id);

        foreach($tracking_dokumen as $trackingDokumen) {

            TrackingDokumen::destroy($trackingDokumen->id);

        }

        flash()
        ->killer(true)
        ->layout('bottomRight')
        ->timeout(3000)
        ->success('<b>Berhasil!</b><br>Data berhasil dihapus.');

        return redirect(route('superAdmin.homepage'));

    }

}
