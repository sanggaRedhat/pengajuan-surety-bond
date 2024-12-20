<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manage\SuretyBondController;
use App\Http\Controllers\Public\PublicHomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    return redirect()->route('public-home.index');
});

Route::prefix('surety-bond')->group(function() {
    Route::get('/', [PublicHomeController::class, 'index'])->name('public-home.index');
    Route::post('/', [PublicHomeController::class, 'sendRequest'])->name('public-home.sendRequest');
});

Route::prefix('login')->middleware('guest')->group(function() {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'authenticate'])->name('authenticate');
});

Route::post('berkas/upload', [BerkasController::class, 'upload']);

Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengajuan-baru', [DashboardController::class, 'dashboardAdminNew']);
    Route::get('/pengajuan-request', [DashboardController::class, 'dashboardAdminRequest']);
    Route::get('/pengajuan-proses', [DashboardController::class, 'dashboardAdminProcess']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('berkas/{filename}',[BerkasController::class, 'view'])->name('view_berkas');

    Route::middleware('can:is-admin')->group(function() {
        Route::get('pengguna', [UserController::class, 'index'])->name('pengguna.index');
        Route::get('pengguna/{pengguna}', [UserController::class, 'edit'])->name('pengguna.edit');
        Route::get('pengguna/edit-akses/{pengguna}', [UserController::class, 'editAkses'])->name('pengguna.editAkses');
        Route::put('pengguna/edit-akses/{pengguna}', [UserController::class, 'updateAkses'])->name('pengguna.updateAkses');
        Route::put('pengguna/{pengguna}', [UserController::class, 'update'])->name('pengguna.update');
        Route::put('pengguna/aktif/{pengguna}', [UserController::class, 'active']);
        Route::post('pengguna', [UserController::class, 'store'])->name('pengguna.store');
        Route::delete('pengguna/{pengguna}', [UserController::class, 'destroy'])->name('pengguna.destroy');
        
    });
    
    Route::get('profil-saya', [UserController::class, 'profil_saya'])->name('pengguna.profil_saya');
    Route::post('profil-saya', [UserController::class, 'update_password'])->name('pengguna.update_password');

    // Manage
    Route::prefix('manage')->group(function() {
        Route::get('surety-bond', [SuretyBondController::class, 'index'])->name('surety-bond.index');
        Route::get('surety-bond/{surety_bond}', [SuretyBondController::class, 'show'])->name('surety-bond.show');
        Route::post('surety-bond/request-to', [SuretyBondController::class, 'requestTo'])->name('surety-bond.requestTo');
        Route::put('surety-bond/update-status/{surety_bond}', [SuretyBondController::class, 'updateStatus'])->name('surety-bond.updateStatus');;
    });
});
