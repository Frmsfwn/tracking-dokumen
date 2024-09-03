<?php

namespace App\Http\Controllers;

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

                    return redirect(route('superAdmin.homepage'));

                }elseif (Auth::user()->role === 'Admin') {

                    return redirect(route('admin.homepage'));

                }elseif (Auth::user()->role === 'PIC') {
                    
                    return redirect(route('pic.homepage'));

                }

            }else {

                return redirect(route('login'))
                    ->withErrors([
                        'password' => 'Password tidak sesuai.',
                    ],'login')
                    ->onlyInput('username');

            }
        }else {

            return redirect(route('login'))
                ->withErrors([
                    'username' => "Akun dengan username; $request->username tidak ditemukan.",
                ],'login')
                ->onlyInput('username');

        }

    }

    function Homepage()
    {
        if(Auth::user()->role === 'SuperAdmin') {

            return view('superAdmin.index');

        }elseif(Auth::user()->role === 'Admin') {

            return view('admin.homepage');

        }elseif(Auth::user()->role === 'PIC') {

            return view('pic.homepage');

        }

    }

    function logout()
    {

        Auth::logout();
        return redirect(route('login'));

    }

}
