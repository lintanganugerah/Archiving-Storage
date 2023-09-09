<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Berkas;
use App\Models\Agunan;
use App\Models\Pinjam;
use App\Models\Pengembalian;
use App\Models\Recovery;
use Illuminate\Support\Str;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Riwayat;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Contracts\Support\ValidatedData;

class cabangController extends Controller
{
    public function viewBeranda()
    {
        $user = session('unit');
        $tanggal = Carbon::now()->format('Y-m-d');
        $tabungan = Berkas::whereDate('created_at', $tanggal)->where('jenis', 'tabungan')->count(); 
        $kredit = Berkas::whereDate('created_at', $tanggal)->where('jenis', 'kredit')->count(); 
        $lunas = Berkas::whereDate('created_at', $tanggal)->where('jenis', 'lunas')->count(); 
        $daftarhitam = Berkas::whereDate('created_at', $tanggal)->where('jenis', 'daftar hitam')->count(); 

        
        $data = [
            'allberkas' => Berkas::all()->count(),
            'kredit' => Berkas::all()->where('jenis', 'Kredit')->count(),
            'tabungan' => Berkas::all()->where('jenis', 'Tabungan')->count(),
            'lunas' => Berkas::all()->where('jenis', 'Lunas')->count(),
            'daftarhitam' => Berkas::all()->where('jenis', 'Daftar Hitam')->count(),
            'dipinjam' => Pinjam::all()->where('status', 'dikonfirmasi')->count(),
        ];

        $berkas = Berkas::orderBy('created_at', 'asc')->get();

        return view('cabang.beranda', compact('data', 'tanggal', 'tabungan', 'kredit', 'lunas', 'daftarhitam'));
    }

    public function viewUser()
    {
        $unit = session('unit');
        $users = User::all();

        return view('cabang.user', compact('users'));
    }

    public function destroy(User $user)
    {
        $name = session('name');
        if ($user->name == $name) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
        } else if ($user->role == 'User') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus user');
        }

        $device = Agent::browser() . ' ' . Agent::platform();

        $riwayat = [
            'kategori' => 'Manajemen Pengguna',
            'user' => session('name'),
            'role' => session('role'),
            'judul_aktivitas' => 'Menghapus Pengguna',
            'aktivitas' => session('role') . ' ' . session('name') . ' menghapus pengguna ' . $user->name . ' unit ' . $user->unit,
            'perangkat' => $device,
            'unit' => session('unit'),
        ];

        Riwayat::create($riwayat);

        $user->delete();

        return redirect()->route('cabang.user.view')->with('success', 'User berhasil dihapus.');
    }

    public function editUserView($id)
    {
        $user = User::find($id);


        return view('cabang.useredit', compact('user'));
    }

    public function resetPassword($id)
    {
        $user = User::find($id);

        $passbaru = Str::random(8);
        $user->password = Hash::make($passbaru);
        $user->reset = session('name');
        $user->save();

        $device = Agent::browser() . ' ' . Agent::platform();

        $riwayat = [
            'kategori' => 'Manajemen Penggua',
            'user' => session('name'),
            'role' => session('role'),
            'judul_aktivitas' => 'Reset Password pengguna',
            'aktivitas' => session('role') . ' ' . session('name') . ' melakukan reset password milik ' . $user->name,
            'perangkat' => $device,
            'unit' => session('unit'),
        ];

        Riwayat::create($riwayat);

        return view('cabang.kodepassword', compact('passbaru'));
    }

    public function create()
    {
        $userUnit = Auth::user();
        $roles = $userUnit->role;
        $unit = Unit::all();
        return view('cabang.usercreate', compact('roles', 'unit'));
    }
    // End manajemen user

    // Manajemen berkas

    public function viewBerkas()
    {

        // Ambil data berkas dari database
        $berkas = Berkas::all();
        $agunan = Agunan::all();

        // Tampilkan halaman dengan data berkas
        return view('cabang.databerkas', compact('berkas', 'agunan'));
    }

    public function viewRiwayat()
    {
        $riwayat = Riwayat::latest()->where('role', 'Admin Cabang')->whereNull('recovery')->get();
        $riwayatAdmin = Riwayat::latest()->where('role', 'Admin')->get();
        $riwayatstaff = Riwayat::latest()->where('role', 'User')->whereNull('recovery')->get();

        return view('cabang.logaktivitas', compact('riwayatAdmin', 'riwayat', 'riwayatstaff'));
    }

    // PROFILE

    public function viewProfile()
    {
        $user = User::where('id', session('uid'))->first();

        return view('cabang.profile', compact('user'));
    }

    public function profileresetPassword()
    {
        return view('cabang.resetpassword');
    }

    public function attemptPassword(Request $request)
    {
        $user = User::find(session('uid'));

        $valPasswordBaru = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'passwordbaru' => 'required|min:8',
            'konfirmasipassword' => 'required|min:8|in:' . $request->passwordbaru,
        ]);

        if ($valPasswordBaru->fails()) {
            return redirect()->back()->with(['error' => 'Password baru dan Konfirmasi password tidak sama']);
        }

        if (Hash::check($request->password, $user->password)) {
            $userData = $request->only(["passwordbaru"]);
            $userData['password'] = Hash::make($userData['passwordbaru']);
            $user->update($userData);
            $user->reset = null;
            $user->save();

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Profile',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Perubahan password',
                'aktivitas' => session('name') . ' mengubah password akun pada perangkat ' . $device,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('cabang.viewProfile')->with(['success' => 'Password berhasil diganti']);
        } else {
            return redirect()->back()->with(['error' => 'Password aktif salah']);
        }
    }

    public function ubahProfile(Request $request)
    {
        $user = User::find(session('uid'));

        $valPasswordBaru = Validator::make($request->all(), [
            'email' => 'required|email|min:8|not_in:' . $user->email,
        ]);

        if ($valPasswordBaru->fails()) {
            return redirect()->back()->with(['error' => 'Tidak ada perubahan terjadi']);
        }

        if (Hash::check($request->password, $user->password)) {

            $userData = $request->only(["email"]);
            $user->update($userData);

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Profile',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Perubahan profile',
                'aktivitas' => session('name') . ' melakukan perubahan profile pada perangkat ' . $device,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('cabang.viewProfile')->with(['success' => 'Informasi Profile berhasil diganti']);
        } else {
            return redirect()->back()->with(['error' => 'Password salah']);
        }
    }

    public function detailBerkas($id)
    {
        $berkas = Berkas::find($id);
        $cif = $berkas->cif;
        $agunan = Agunan::where("cif", $cif)->first();
        $update = Recovery::latest()->where('berkas_id', $id)->first();
        if ($update) {
            $update = Riwayat::latest()->where('recovery_id', $update->id)->first();
        }

        return view('cabang.detailberkas', compact('berkas', 'agunan', 'update'));
    }

    
    public function viewUnit()
    {
        $unit = Unit::all();

        return view('cabang.unit', compact('unit'));
    }

    public function createUnit()
    {
        return view('cabang.unitcreate');
    }

    public function attemptUnit(Request $request)
    {
        $validatedData = $request->validate([
            'unit' => 'required|string',
            'kode' => 'required|string'
        ]);

        Unit::create($validatedData);
        return redirect()->route('cabang.viewUnit')->with(['success' => 'Berhasil membuat unit baru']);
    }
}
