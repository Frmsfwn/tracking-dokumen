<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    function dataUser(Request $request)
    {
        $keyword = $request->input('keyword');

        $data_user = User::whereNot('role','SuperAdmin')->paginate(8);

        if ($keyword) {
            $data_user = User::whereNot('role','SuperAdmin')
                ->whereAny(['nip', 'nama', 'role'], 'LIKE', "%{$keyword}%")
                ->orderBy('updated_at','DESC')
                ->paginate(8);
        }

        return view('SuperAdmin.dataUser')
            ->with('data_user',$data_user);
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

        ],$messages)->validateWithBag('tambah_data');

        $inputeddata = [

            'nip' => $request->input('nip_user'),
            'nama' => $request->input('nama_user'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),

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

    function statusDokumen()
    {

        return view('SuperAdmin.ubahStatus');

    }

}
