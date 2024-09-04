<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'preventBackHistory'], function(){

    Route::group(['middleware' => 'guest'], function(){

        // Login Function for Guest User
        Route::get('/login', [LoginController::class, 'show'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::get('/', function() {
            return redirect(route('login'));
        });

    });
    Route::group(['middleware' => 'auth'], function(){

        // Logout Function for Authenticated User
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        // Change Password Function
        Route::get('/password/edit', [LoginController::class, 'editPassword'])->name('edit.password');
        Route::put('{User}/password/update', [LoginController::class, 'updatePassword'])->name('update.password');

        Route::prefix('superAdmin')->name('superAdmin.')->middleware(['userAccess:SuperAdmin'])->group(function() {

            route::get('/homepage', [LoginController::class, 'homepage'])->name('homepage');
            route::get('/data/dokumen/status', [SuperAdminController::class, 'statusDokumen'])->name('status.dokumen');
            route::get('/data/user', [SuperAdminController::class, 'dataUser'])->name('show.user');
            route::post('/data/user/create', [SuperAdminController::class, 'createUser'])->name('create.user');
            route::put('/data/user/{User}/update', [SuperAdminController::class, 'updateUser'])->name('update.user');
            route::delete('/data/user/{User}/delete', [SuperAdminController::class, 'deleteUser'])->name('delete.user');

        });
        Route::prefix('admin')->name('admin.')->middleware(['userAccess:Admin'])->group(function() {

            route::get('/homepage', [LoginController::class, 'homepage'])->name('homepage');
            route::get('/data/dokumen/create', [AdminController::class, 'createDokumen'])->name('create.dokumen');
            route::get('/data/dokumen/status', [AdminController::class, 'statusDokumen'])->name('status.dokumen');
            
        });    
        Route::prefix('pic')->name('pic.')->middleware(['userAccess:PIC'])->group(function() {



        });

    });

});
