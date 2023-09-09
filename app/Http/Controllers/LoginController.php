<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Riwayat;
use App\Models\User;

class LoginController extends Controller
{
    public function viewLogin()
    {

        $role = session('role');

        if ($role == "Admin") {
            return redirect('/admin/beranda');
        } else if ($role == "User") {
            return redirect('/home');
        } else if ($role == "Admin Cabang") {
            return redirect('/cabang/beranda');
        } else {
            return view('login');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();


            session(['loggedin' => TRUE]);
            session(['uid' => $user->id]);
            session(['name' => $user->name]);
            session(['email' => $user->email]);
            session(['role' => $user->role]);
            session(['unit' => $user->unit]);

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Autentikasi',
                'user' => $user->name,
                'role' => session('role'),
                'judul_aktivitas' => 'Melakukan login',
                'aktivitas' => $user->role . ' ' . session('name') . ' melakukan login menggunakan perangkat ' . $device . ' pada ' . now(),
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            if (isset($user->reset)) {
                if ($user->role == "Admin") {
                    return redirect('/admin/beranda')->with(['error' => 'SEGERA GANTI PASSWORD ANDA! TEKAN NAMA ANDA DIATAS INI, DAN LAKUKAN PERUBAHAN PASSWORD']);
                } else if ($user->role == "Admin Cabang") {
                    return redirect('/cabang/beranda');
                } else {
                    return redirect('/home')->with(['error' => 'SEGERA GANTI PASSWORD ANDA! TEKAN NAMA ANDA DIATAS INI, DAN LAKUKAN PERUBAHAN PASSWORD']);
                }
            } else {
                if ($user->role == "Admin") {
                    return redirect('/admin/beranda');
                } else if ($user->role == "Admin Cabang") {
                    return redirect('/cabang/beranda');
                } else {
                    return redirect('/home');
                }
            }
        } else {
            $user = User::where('email', $credentials['email'])->first();

            if (isset($user->reset)) {
                return redirect()->route('viewLogin')->with(['error' => 'Password anda diubah oleh admin ' . $user->reset . '! Masukan kode yang diberikan admin']);
            } else {
                return redirect()->route('viewLogin')->with(['error' => 'Email atau password salah!']);
            }
        }
    }

    public function logout()
    {
        $device = Agent::browser() . ' ' . Agent::platform();
        $user = Auth::user();
        $riwayat = [
            'kategori' => 'Autentikasi',
            'user' => $user->name,
            'role' => session('role'),
            'judul_aktivitas' => 'Melakukan Logout',
            'aktivitas' => $user->role . ' ' . session('name') . ' melakukan loggout menggunakan perangkat ' . $device . ' pada ' . now(),
            'perangkat' => $device,
            'unit' => session('unit'),
        ];

        Riwayat::create($riwayat);

        Auth::logout();
        Session::flush();
        Session::regenerate(true);
        return redirect('/');
    }

    public function register(Request $request)
    {
        $user = Auth::user();
        $unit = $user->unit;
        $roleRegis = $user->role;

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'jabatan' => 'required|string',
            'role' => 'required',
        ]);
        

        $validatedData['password'] = Hash::make($validatedData['password']);
        if ($roleRegis == "Admin") {
            $validatedData['unit'] = $unit;
        } else if ($roleRegis == "Admin Cabang") {
            $validatedData['unit'] = $request->unit;
        } else {
            return redirect()->route('user.view')->with('error', 'Anda tidak memiliki akses untuk membuat pengguna baru');
        }

        $user = User::create($validatedData);

        $device = Agent::browser() . ' ' . Agent::platform();
        
        $riwayat = [
            'kategori' => 'Manajemen Pengguna',
            'user' => session('name'),
            'role' => session('role'),
            'judul_aktivitas' => 'Menambahkan pengguna baru',
            'aktivitas' => session('role') . ' ' . session('name') . ' menambahkan pengguna baru dengan nama ' . $validatedData['name'] . ' pada unit ' . $validatedData['unit'] . ' sebagai ' . $validatedData['role'],
            'perangkat' => $device,
            'unit' => session('unit'),
        ];

        Riwayat::create($riwayat);
        if ($roleRegis == "Admin") {
            return redirect()->route('user.view')->with('success', 'Pengguna baru berhasil ditambahkan.');
        } else if ($roleRegis == "Admin Cabang") {
            return redirect()->route('cabang.user.view')->with('success', 'Pengguna baru berhasil ditambahkan.');
        }
        
    }
}
