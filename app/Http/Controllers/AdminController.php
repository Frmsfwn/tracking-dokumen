<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    
    function createDokumen()
    {

        return view('Admin.DokumenBaru');

    }

    function statusDokumen()
    {

        return view('Admin.ubahStatus');

    }
    
}
