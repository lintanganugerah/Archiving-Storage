<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\cabangController;
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
    
    Route::get('/profile', [UserController::class, 'viewProfile'])->name('user.viewprofile');
    Route::get('/profile/resetpassword', [UserController::class, 'resetPassword'])->name('user.resetPassword');
    Route::post('/profile/attempt/password', [UserController::class, 'attemptPassword'])->name('user.attemptPassword');
    Route::post('/profile/attempt/ubah', [UserController::class, 'ubahProfile'])->name('user.ubahProfile');
    
    Route::get('/peminjaman', [UserController::class, 'viewPeminjaman'])->name('user.viewPeminjaman');
    Route::post('/user/peminjaman/request', [UserController::class, 'requestPeminjaman'])->name('user.reqPeminjaman');
    Route::post('/user/peminjaman/attempt/{id}', [UserController::class, 'attemptPeminjaman'])->name('user.attemptPinjam');
    Route::post('/user/peminjaman/batalkan/{id}', [UserController::class, 'batalkanPeminjaman'])->name('user.batalkanPinjam');
    
    Route::post('/user/pengembalian/attempt/{id}', [UserController::class, 'attemptPengembalian'])->name('user.attemptPengembalian');
    Route::post('/user/pengembalian/batalkan/{id}', [UserController::class, 'batalkanPengembalian'])->name('user.batalkanPengembalian');
    
    Route::get('/pengembalian', [UserController::class, 'viewPengembalian'])->name('user.viewPengembalian');

    Route::get('/riwayat', [UserController::class, 'viewRiwayat'])->name('user.viewRiwayat');

    Route::post('/catatan/update/{id}', [UserController::class, 'catatanUpdate'])->name('user.catatanUpdate');

    
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

    Route::get('/log', [AdminController::class, 'viewRiwayat'])->name('admin.viewRiwayat');
    Route::post('/recovery/aksi/{id}', [AdminController::class, 'recovery'])->name('admin.recovery');
    
    // Rute user
    Route::get('/admin/user', [AdminController::class, 'viewUser'])->name('user.view');
    Route::delete('/admin/delete/{user}', [AdminController::class, 'destroy'])->name('user.destroy');
    Route::get('/admin/edit/user/{id}', [AdminController::class, 'editUserView'])->name('user.editView');
    Route::get('/admin/user/create', [AdminController::class, 'create'])->name('user.create');
    Route::post('admin/users/store', [LoginController::class, 'register'])->name('user.register');
    Route::post('admin/users/resetpassword/{id}', [AdminController::class, 'resetPassword'])->name('admin.resetPassword');

    Route::get('/admin/profile', [AdminController::class, 'viewProfile'])->name('admin.viewProfile');
    Route::get('/admin/profile/resetpassword', [AdminController::class, 'profileresetPassword'])->name('admin.profileresetPassword');
    Route::post('/admin/profile/attempt/password', [AdminController::class, 'attemptPassword'])->name('admin.attemptPassword');
    Route::post('/admin/profile/attempt/ubah', [AdminController::class, 'ubahProfile'])->name('admin.ubahProfile');
    Route::get('/admin/detailberkas/{id}', [AdminController::class, 'detailBerkas'])->name('admin.detailberkas');
});

Route::group(['middleware' => 'Admin Cabang'], function () {
    Route::get('/cabang/beranda', [cabangController::class, 'viewBeranda'])->name('cabang.viewBeranda');
    
    Route::get('/cabang/unit', [cabangController::class, 'viewUnit'])->name('cabang.viewUnit');
    Route::get('/cabang/unit/create', [cabangController::class, 'createUnit'])->name('cabang.createUnit');
    Route::post('/cabang/unit/post', [cabangController::class, 'attemptUnit'])->name('cabang.attemptUnit');

    Route::post('/cabang/user/updateRole/{id}', [cabangController::class, 'updateUserRole'])->name('cabang.updateUserRole');

    // Rute Berkas
    Route::get('/cabang/databerkas', [cabangController::class, 'viewBerkas'])->name('cabang.berkas');

    Route::get('/cabang/editberkas/{id}', [cabangController::class, 'editBerkas'])->name('cabang.editberkas');
    Route::post('/cabang/editberkas/attempt/{id}', [cabangController::class, 'attemptEditBerkas'])->name('cabang.attemptEditBerkas');

    Route::get('/cabang/log', [cabangController::class, 'viewRiwayat'])->name('cabang.viewRiwayat');
    
    // Rute user
    Route::get('/cabang/user', [cabangController::class, 'viewUser'])->name('cabang.user.view');
    Route::delete('/cabang/delete/{user}', [cabangController::class, 'destroy'])->name('cabang.user.destroy');
    Route::get('/cabang/edit/user/{id}', [cabangController::class, 'editUserView'])->name('cabang.user.editView');
    Route::get('/cabang/user/create', [cabangController::class, 'create'])->name('cabang.user.create');
    Route::post('cabang/users/store', [LoginController::class, 'register'])->name('cabang.user.register');
    Route::post('cabang/users/resetpassword/{id}', [cabangController::class, 'resetPassword'])->name('cabang.resetPassword');

    Route::get('/cabang/profile', [cabangController::class, 'viewProfile'])->name('cabang.viewProfile');
    Route::get('/cabang/profile/resetpassword', [cabangController::class, 'profileresetPassword'])->name('cabang.profileresetPassword');
    Route::post('/cabang/profile/attempt/password', [cabangController::class, 'attemptPassword'])->name('cabang.attemptPassword');
    Route::post('/cabang/profile/attempt/ubah', [cabangController::class, 'ubahProfile'])->name('cabang.ubahProfile');

    Route::get('/cabang/detailberkas/{id}', [cabangController::class, 'detailBerkas'])->name('cabang.detailberkas');
});
