<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\TrackingDokumen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    
    function show()
    {
        return view('main.login');
    }

    function login(Request $request)
    {
        $messages = [

            'username.required' => 'Username tidak dapat kosong.',
            'username.max' => 'Username maksimal berisi 15 karakter.',
            'password.required' => 'Password tidak dapat kosong.',
            'password.max' => 'Password maksimal berisi 50 karakter.',

        ];

        Validator::make($request->input(), [

            'username' => 'required|max:15',
            'password' => 'required|max:50', 

        ],$messages)->validateWithBag('login');

        if (User::where('username','=',$request->input('username'))->exists()) {

            $inputeddata = [

                'username' => $request->input('username'),
                'password' => $request->input('password'),

            ];
    
            if (Auth::attempt($inputeddata)) {

                if (Auth::user()->role === 'SuperAdmin') {

                    flash()
                    ->killer(true)
                    ->layout('bottomRight')
                    ->timeout(3000)
                    ->success('<b>Berhasil!</b><br>Proses login berhasil.');

                    return redirect(route('superAdmin.homepage'));

                }elseif (Auth::user()->role === 'Admin') {

                    flash()
                    ->killer(true)
                    ->layout('bottomRight')
                    ->timeout(3000)
                    ->success('<b>Berhasil!</b><br>Proses login berhasil.');

                    return redirect(route('admin.homepage'));

                }elseif (Auth::user()->role === 'PIC') {

                    flash()
                    ->killer(true)
                    ->layout('bottomRight')
                    ->timeout(3000)
                    ->success('<b>Berhasil!</b><br>Proses login berhasil.');
                    
                    return redirect(route('pic.homepage'));

                }

            }else {

                flash()
                ->killer(true)
                ->layout('bottomRight')
                ->timeout(3000)
                ->error('<b>Kesalahan!</b><br>Proses login gagal.');

                return redirect(route('login'))
                    ->withErrors([
                        'password' => 'Password tidak sesuai.',
                    ],'login')
                    ->onlyInput('username');

            }
        }else {

            flash()
            ->killer(true)
            ->layout('bottomRight')
            ->timeout(3000)
            ->error('<b>Kesalahan!</b><br>Proses login gagal.');

            return redirect(route('login'))
                ->withErrors([
                    'username' => "Akun dengan username; $request->username tidak ditemukan.",
                ],'login')
                ->onlyInput('username');

        }

    }

    function editPassword()
    {

        return view('main.ubahPassword');

    }

    function updatePassword(User $User, Request $request)
    {
        $messages = [

            'password_lama.required' => 'Kolom password tidak dapat kosong.',
            'password_lama.max' => 'Kolom password maksimal berisi 16 karakter.',
            'password_lama.current_password' => 'Password tidak sesuai',
            'password_baru.min' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_baru.max' => 'Password maksimal berisi 16 terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_baru.regex' => 'Password minimal berisi 8 karakter terdiri dari; huruf besar dan huruf kecil, angka, dan simbol.',
            'password_baru.required' => 'Password tidak dapat kosong.',
            'konfirmasi_password.required' => 'Kolom password tidak dapat kosong.',
            'konfirmasi_password.max' => 'Kolom password maksimal berisi 50 karakter.',
            'konfirmasi_password.same' => 'Password tidak sesuai',

        ];

        Validator::make($request->input(), [

            'password_lama' => 'required|max:50|current_password:web',
            'password_baru' => ['required','min:8','max:16','regex:/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/'],
            'konfirmasi_password' => 'required|max:50|same:password_baru',
            
        ],$messages)->validateWithBag('ubah_password');

        $User->update([ 'password' => bcrypt($request->input('konfirmasi_password')) ]);

        Auth::logout();
        return redirect(route('login'));
    }

    function Homepage(Request $request)
    {
        
        if(Auth::user()->role === 'SuperAdmin') {

            $keyword = $request->input('keyword');
            $filter = $request->input('filter', 'all');

            $data_dokumen = Dokumen::orderByRaw("FIELD(status, 'proses', 'selesai')")->paginate(8);
            $jumlah_dokumen_proses = Dokumen::where('status','proses')->count();
            
            if ($keyword) {
                $data_dokumen = Dokumen::whereAny([
                    'nomor_surat',
                    'tim_teknis',
                    'tanggal_awal_dinas',
                    'tanggal_akhir_dinas',
                    'sisa_hari',
                    'status'], 'LIKE', "%{$keyword}%")
                    ->orderByRaw("FIELD(status, 'proses', 'selesai')")
                    ->paginate(8);
            }

            if ($filter) {
                if ($filter == 'process') {
                    $data_dokumen = Dokumen::where('status', 'proses')->paginate(8);
                }
            }            

            return view('superAdmin.index')
                ->with('data_dokumen', $data_dokumen)
                ->with('jumlah_dokumen_proses', $jumlah_dokumen_proses)
                ->with('filter', $filter);

        }elseif(Auth::user()->role === 'Admin') {
            
            $keyword = $request->input('keyword');
            $filter = $request->input('filter', 'all');

            $data_dokumen = Dokumen::orderByRaw("FIELD(status, 'proses', 'selesai')")->paginate(8);
            $jumlah_dokumen_proses = Dokumen::where('status','proses')->count();
            $data_terakhir = Dokumen::orderBy('updated_at', 'DESC')->limit(3)->get();

            
            if ($keyword) {
                $data_dokumen = Dokumen::whereAny([
                    'nomor_surat',
                    'tim_teknis',
                    'tanggal_awal_dinas',
                    'tanggal_akhir_dinas',
                    'sisa_hari',
                    'status'], 'LIKE', "%{$keyword}%")
                    ->orderByRaw("FIELD(status, 'proses', 'selesai')")
                    ->paginate(8);
            }

            if ($filter) {
                if ($filter == 'process') {
                    $data_dokumen = Dokumen::where('status', 'proses')->paginate(8);
                }
            }

            return view('admin.index')
                ->with('data_dokumen',$data_dokumen)
                ->with('jumlah_dokumen_proses',$jumlah_dokumen_proses)
                ->with('filter',$filter)
                ->with('data_terakhir', $data_terakhir);

        }elseif(Auth::user()->role === 'PIC') {

            $keyword = $request->input('keyword');
            $filter = $request->input('filter', 'all');

            $data_dokumen = Dokumen::where('tim_teknis', Auth::user()->tim_teknis)->
                            orderByRaw("FIELD(status, 'proses', 'selesai')")->paginate(8);
                            
            $jumlah_dokumen_proses = Dokumen::where('tim_teknis', Auth::user()->tim_teknis)
                            ->where('status','proses')->count();
            
            if ($keyword) {
                $data_dokumen = Dokumen::where('tim_teknis', Auth::user()->tim_teknis)->
                whereAny([
                    'nomor_surat',
                    'tim_teknis',
                    'tanggal_awal_dinas',
                    'tanggal_akhir_dinas',
                    'sisa_hari',
                    'status'], 'LIKE', "%{$keyword}%")
                    ->orderByRaw("FIELD(status, 'proses', 'selesai')")
                    ->paginate(8);
            }

            if ($filter) {
                if ($filter == 'process') {
                    $data_dokumen = Dokumen::where('tim_teknis', Auth::user()->tim_teknis)->
                                        where('status', 'proses')->paginate(8);
                }
            }

            return view('pic.index')
                ->with('data_dokumen',$data_dokumen)
                ->with('jumlah_dokumen_proses',$jumlah_dokumen_proses)
                ->with('filter',$filter);

        }

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

        return view('pic.ubahStatus')
            ->with('data_dokumen',$data_dokumen)
            ->with('data_tracking',$data_tracking);

    }

    function logout()
    {

        Auth::logout();
        return redirect(route('login'));

    }

}
