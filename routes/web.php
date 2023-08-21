<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;

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

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/', [LoginController::class, 'viewLogin'])->name('viewLogin');

Route::post('/loginattempt', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'User'], function () {
    
    Route::get('/home', [UserController::class, 'viewHome'])->name('user.viewHome');
    
    Route::get('/peminjaman', [UserController::class, 'viewPeminjaman'])->name('user.viewPeminjaman');
    Route::post('/user/peminjaman/request', [UserController::class, 'requestPeminjaman'])->name('user.reqPeminjaman');
    Route::post('/user/peminjaman/attempt/{id}', [UserController::class, 'attemptPeminjaman'])->name('user.attemptPinjam');
    Route::post('/user/peminjaman/batalkan/{id}', [UserController::class, 'batalkanPeminjaman'])->name('user.batalkanPinjam');
    
    Route::post('/user/pengembalian/attempt/{id}', [UserController::class, 'attemptPengembalian'])->name('user.attemptPengembalian');
    Route::post('/user/pengembalian/batalkan/{id}', [UserController::class, 'batalkanPengembalian'])->name('user.batalkanPengembalian');
    
    Route::get('/pengembalian', [UserController::class, 'viewPengembalian'])->name('user.viewPengembalian');

    Route::get('/riwayat', function () {
        return view('riwayat');
    });

    
});

Route::group(['middleware' => 'Admin'], function () {
    Route::get('/admin/beranda', [AdminController::class, 'viewBeranda'])->name('admin.viewBeranda');

    Route::post('/admin/user/updateRole/{id}', [AdminController::class, 'updateUserRole'])->name('admin.updateUserRole');

    Route::post('/admin/konfirmasi/attempt/{id}', [AdminController::class, 'konfirmasiPeminjaman'])->name('user.konfirmasiPinjam');
    Route::post('/admin/tolak/attempt/{id}', [AdminController::class, 'tolakPeminjaman'])->name('user.tolakPinjam');
    
    Route::post('/admin/pengembalian/konfirmasi/{id}', [AdminController::class, 'konfirmasiPengembalian'])->name('user.konfirmasiPengembalian');
    Route::post('/admin/pengembalian/tolak/{id}', [AdminController::class, 'tolakPengembalian'])->name('user.tolakPengembalian');

    // Rute Berkas
    Route::get('/admin/databerkas', [AdminController::class, 'viewBerkas'])->name('admin.berkas');

    Route::get('/admin/editberkas/{id}', [AdminController::class, 'editBerkas'])->name('admin.editberkas');
    Route::post('/admin/editberkas/attempt/{id}', [AdminController::class, 'attemptEditBerkas'])->name('admin.attemptEditBerkas');

    Route::get('/admin/databerkas/create', [AdminController::class, 'createBerkas'])->name('admin.createBerkas');
    Route::post('/admin/new/berkas', [AdminController::class, 'storeBerkas'])->name('admin.storeBerkas');

    Route::get('/admin/logaktivitas', function () {
        return view('admin.logaktivitas');
    });
    
    // Rute user
    Route::get('/admin/user', [AdminController::class, 'viewUser'])->name('user.view');
    Route::delete('/admin/delete/{user}', [AdminController::class, 'destroy'])->name('user.destroy');
    Route::get('/admin/edit/user', [AdminController::class, 'editUserView'])->name('user.editView');
    Route::get('/admin/user/create', [AdminController::class, 'create'])->name('user.create');
    Route::post('admin/users/store', [LoginController::class, 'register'])->name('user.register');
});
