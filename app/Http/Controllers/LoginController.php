<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
            session(['lokasi' => $user->unit]);
            // if ($request->remember) {
            //     Cookie::queue('email', $user->email, 1440);
            //     Cookie::queue('password', $request->password, 1440);
            //     Cookie::queue('remember', TRUE, 1440);
            // } else {
            //     Cookie::queue('email', "", 0);
            //     Cookie::queue('password', "", 0);
            //     Cookie::queue('remember', "", 0);
            // }
            if ($user->role == "Admin") {
                return redirect('/admin/beranda');
            } else {
                return redirect('/home');
            }
        } else {
            return redirect()->route('viewLogin')->with(['error' => 'Email atau password salah!']);
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        Session::regenerate(true);
        return redirect('/'); // Ganti /login dengan halaman login yang sesuai.
    }

    public function register(Request $request)
    {
        $user = Auth::user();
        $unit = intval($user->unit);
        $roleRegis = $user->role;

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'jabatan' => 'required|string',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['unit'] = $unit;
        if ($roleRegis=="Admin") {
            $validatedData['unit'] = $unit;
        } else if ($roleRegis=="Admin Cabang") {
            $validatedData['unit'] = $request->unit;
        } else {
            return redirect()->route('user.view')->with('error', 'Anda tidak memiliki akses untuk membuat pengguna baru');
        }

        $user = User::create($validatedData);

        // Assign role 'user' to the newly registered user.
        $user->update(['role' => $request->role]);

        return redirect()->route('user.view')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }
}
