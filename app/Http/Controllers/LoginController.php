<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    function Homepage()
    {
        if(Auth::user()->role === 'SuperAdmin') {

            return view('superAdmin.index');

        }elseif(Auth::user()->role === 'Admin') {

            $data_dokumen = Dokumen::all();

            return view('admin.index')
                ->with('data_dokumen',$data_dokumen);

        }elseif(Auth::user()->role === 'PIC') {

            return view('pic.index');

        }

    }

    function logout()
    {

        Auth::logout();
        return redirect(route('login'));

    }

}
