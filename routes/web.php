<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MasyarakatController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\TanggapanController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'index'])->name('pekat.index');

Route::middleware(['isMasyarakat'])->group(function(){

    Route::post('store', [UserController::class, 'storePengaduan'])->name('pekat.store');
    Route::get('laporan/{siapa?}', [UserController::class, 'laporan'])->name('pekat.laporan');

    Route::get('logout', [UserController::class, 'logout'])->name('pekat.logout');

});

Route::middleware(['guest'])->group(function(){

    Route::post('login', [UserController::class, 'login'])->name('pekat.login');

    Route::post('register', [UserController::class, 'register'])->name('pekat.register');
    Route::get('register/form', [UserController::class, 'formRegister'])->name('pekat.formRegister');

});

Route::prefix('admin')->group(function(){

    Route::middleware(['isAdmin'])->group(function(){

        Route::resource('masyarakat', MasyarakatController::class);
        Route::resource('petugas', PetugasController::class);
        
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('getLaporan', [LaporanController::class, 'getLaporan'])->name('laporan.getLaporan');

        Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('pengaduan/show', [PengaduanController::class, 'show'])->name('pengaduan.show');

    });
});

Route::middleware(['isPetugas'])->group(function(){

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('pengaduan/show', [PengaduanController::class, 'show'])->name('pengaduan.show');

    Route::post('tanggapan/createOrUpdate', TanggapanController::class, 'createOrUpdate')->name('tanggapan.createOrUpdate');

    Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['isGuest'])->group(function(){

    Route::get('admin/login', [AdminController::class, 'formLogin'])->name('admin.formLogin');
    Route::get('login', [AdminController::class, 'login'])->name('admin.login');
});
