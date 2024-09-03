<?php

use App\Http\Controllers\LoginController;
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


});

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


        });
        Route::prefix('admin')->name('admin.')->middleware(['userAccess:Admin'])->group(function() {

            
        });    
        Route::prefix('pic')->name('pic.')->middleware(['userAccess:PIC'])->group(function() {


        });

    });

});
