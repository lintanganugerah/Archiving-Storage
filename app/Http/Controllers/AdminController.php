<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Berkas;
use App\Models\Agunan;
use App\Models\Pinjam;
use App\Models\Pengembalian;
use Illuminate\Support\Str;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Validator;
use App\Models\Riwayat;
use App\Models\Recovery;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Manajemen user
    public function viewBeranda()
    {
        $user = session('unit');
        $peminjaman = Pinjam::where('lokasi', $user)->where('status', 'menunggu')->get();
        $pengembalian = Pengembalian::where('lokasi', $user)->where('status', 'menunggu')->get();
        $pengembalian2 = Pengembalian::where('lokasi', $user)->where('status', 'menunggu 2')->get();
        $allberkas = Berkas::where('lokasi', $user)->where('status', 'ada')->count();
        $dipinjam = Pinjam::where('lokasi', $user)->where('status', 'dikonfirmasi');
        $data = [
            'peminjaman' => $peminjaman->count(),
            'pengembalian' => $pengembalian->count(),
            'allberkas' => $allberkas,
            'dipinjam' => $dipinjam->count(),
        ];

        $dipinjam = $dipinjam->get();

        return view('admin.beranda', compact('peminjaman', 'pengembalian', 'pengembalian2', 'data', 'dipinjam'));
    }

    public function viewUser()
    {
        $unit = session('unit');
        $users = User::where('unit', $unit)->get();

        return view('admin.user', compact('users'));
    }

    public function destroy(User $user)
    {
        $name = session('name');
        if ($user->name == $name) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
        } else if ($user->role == "Admin") {
            return redirect()->back()->with('error', 'Tidak dapat menghapus admin, hubungi admin cabang jika ingin menghapus');
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

        return redirect()->route('user.view')->with('success', 'User berhasil dihapus.');
    }

    public function editUserView($id)
    {
        $user = User::find($id);


        return view('admin.useredit', compact('user'));
    }

    public function resetPassword($id)
    {
        $user = User::find($id);

        if ($user->name == session('nama')) {
            return redirect()->route('user.view')->with('error', 'Tidak dapat menghapus user sendiri');
        }

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

        return view('admin.kodepassword', compact('passbaru'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $current = Auth::user();
        $user = User::find($id);

        if ($current->id == $user->id) {
            return redirect()->back()->with(['error' => 'Tidak dapat mengubah role sendiri']);
        } else {
            $user->update(['role' => $request->selected_role]); // Melakukan perubahan pada kolom "role"

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Manajemen Pengguna',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Mengubah role pengguna',
                'aktivitas' => session('role') . ' ' . session('name') . ' mengubah role ' . $user->name . ' menjadi ' . $request->selected_role,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);
            return redirect()->back()->with(['success' => 'Role ' . $user->name . ' berhasil diubah']);
        }
    }

    public function create()
    {
        $userUnit = Auth::user();
        $roles = $userUnit->role;
        return view('admin.usercreate', compact('roles'));
    }
    // End manajemen user

    // Manajemen berkas
    public function createBerkas()
    {
        // Tampilkan halaman untuk membuat berkas dan agunan baru
        $userUnit = Auth::user();
        $role = $userUnit->role;
        return view('admin.berkascreate', compact('role'));
    }

    public function storeBerkas(Request $request)
    {
        $unit = session('unit');

        // Simpan data berkas dan agunan ke database

        $berkas = [
            "nama" => $request->nama,
            "no_rek" => $request->no_rek,
            "cif" => $request->cif,
            "jenis" => $request->jenis,
            "lokasi" => $unit,
            "ruang" => $request->ruang,
            "lemari" => $request->lemari,
            "rak" => $request->rak,
            "baris" => $request->baris,
            "status" => "ada",
        ];
        if ($request->agunan) {
            $berkas['agunan'] = $request->agunan;
        }

        Berkas::create($berkas);

        if ($request->agunan) {
            $newAgunan = [
                'nama' => $request->nama,
                'cif' => $request->cif,
                'agunan' => $request->agunan,
                'Lokasi' => $unit,
                'ruang_agunan' => $request->ruang_agunan,
                'lemari_agunan' => $request->lemari_agunan,
                'rak_agunan' => $request->rak_agunan,
                'baris_agunan' => $request->baris_agunan
            ];
            Agunan::create($newAgunan);
        }

        $device = Agent::browser() . ' ' . Agent::platform();

        $riwayat = [
            'kategori' => 'Manajemen Berkas',
            'user' => session('name'),
            'role' => session('role'),
            'judul_aktivitas' => 'Tambah berkas',
            'aktivitas' => session('role') . ' ' . session('name') . ' menambah berkas baru atas nama ' . $request->nama . ' dengan jenis berkas ' . $request->jenis,
            'perangkat' => $device,
            'unit' => session('unit'),
        ];

        Riwayat::create($riwayat);

        // Redirect ke halaman tabel berkas atau halaman lainnya jika diperlukan
        return redirect()->route('admin.berkas')->with('success', 'Berkas ' . $request->nama . ' berhasil dibuat');
    }

    public function viewBerkas()
    {
        $userUnit = Auth::user();
        $unit = $userUnit->unit;

        // Ambil data berkas dari database
        $berkas = Berkas::where('Lokasi', $unit)->get();
        $peminjaman = Berkas::where('Lokasi', $unit)->get();
        $agunan = Agunan::where('Lokasi', $unit)->get();

        // Tampilkan halaman dengan data berkas
        return view('admin.databerkas', compact('berkas', 'agunan', 'peminjaman'));
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

        return view('admin.detailberkas', compact('berkas', 'agunan', 'update'));
    }

    public function editBerkas($id)
    {
        $berkas = Berkas::find($id);
        $cif = $berkas->cif;
        $agunan = Agunan::where("cif", $cif)->first();

        return view('admin.editberkas', compact('berkas', 'agunan'));
    }

    public function attemptEditBerkas(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'cif' => 'required|string|min:5|max:7',
            'jenis' => 'required|in:Kredit,Tabungan,Lunas,Daftar Hitam',
            'ruang' => 'required|string',
            'lemari' => 'required|string',
            'rak' => 'required|integer',
            'baris' => 'required|integer',
            'no_rek' => 'required|max:15', // Maksimal 15 karakter
        ]);


        $berkas = Berkas::find($id);
        $cif = $berkas->cif;
        $agunan = Agunan::where('cif', $cif)->first();


        $device = Agent::browser() . ' ' . Agent::platform();

        $recovery = [
            'nama' => $berkas->nama,
            'cif' => $berkas->cif,
            'jenis' => $berkas->jenis,
            'ruang' => $berkas->ruang,
            'lemari' => $berkas->lemari,
            'rak' => $berkas->rak,
            'baris' => $berkas->baris,
            'no_rek' => $berkas->no_rek,
            'lokasi' => $berkas->lokasi,
            'berkas_id' => $berkas->id
        ];

        $riwayat = [
            'kategori' => 'Manajemen Berkas',
            'user' => session('name'),
            'role' => session('role'),
            'judul_aktivitas' => 'Edit berkas',
            'aktivitas' => 'Perubahan pada berkas ' . $berkas->nama . ' dengan perubahan yaitu :',
            'perangkat' => $device,
            'recovery' => 'ya',
            'unit' => session('unit'),
        ];


        if ($validatedData['nama'] != $berkas->nama) {
            $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan nama ' . $berkas->nama . ' -> ' . $validatedData['nama'];
        }

        if ($validatedData['no_rek'] != $berkas->no_rek) {
            $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan rekening ' . $berkas->no_rek . ' -> ' . $validatedData['no_rek'];
        }

        if ($validatedData['cif'] != $berkas->cif) {
            $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan CIF ' . $berkas->cif . ' -> ' . $validatedData['cif'];
        }

        if ($validatedData['jenis'] != $berkas->jenis) {
            $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan jenis ' . $berkas->jenis . ' -> ' . $validatedData['jenis'];
        }

        if ($validatedData['ruang'] != $berkas->ruang) {
            $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan ruang ' . $berkas->ruang . ' -> ' . $validatedData['ruang'];
        }

        if ($validatedData['lemari'] != $berkas->lemari) {
            $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan lemari ' . $berkas->lemari . ' -> ' . $validatedData['lemari'];
        }

        if ($validatedData['rak'] != $berkas->rak) {
            $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan rak ' . $berkas->rak . ' -> ' . $validatedData['rak'];
        }

        if ($validatedData['baris'] != $berkas->baris) {
            $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan baris ' . $berkas->baris . ' -> ' . $validatedData['baris'];
        }


        $berkas->update([
            'nama' => $validatedData['nama'],
            'cif' => $validatedData['cif'],
            'jenis' => $validatedData['jenis'],
            'ruang' => $validatedData['ruang'],
            'lemari' => $validatedData['lemari'],
            'rak' => $validatedData['rak'],
            'baris' => $validatedData['baris'],
            'no_rek' => $validatedData['no_rek'],
        ]);

        if ($request->agunan) {
            if ($agunan) {
                $validatedDataAgunan = $request->validate([
                    'agunan' => 'required|string',
                    'ruang_agunan' => 'required|integer',
                    'lemari_agunan' => 'required|string',
                    'rak_agunan' => 'required|integer',
                    'baris_agunan' => 'required|integer',
                ]);
                $recovery['agunan'] = $agunan->agunan;
                $recovery['ruang_agunan'] = $agunan->ruang_agunan;
                $recovery['lemari_agunan'] = $agunan->lemari_agunan;
                $recovery['rak_agunan'] = $agunan->rak_agunan;
                $recovery['baris_agunan'] = $agunan->baris_agunan;

                if ($validatedDataAgunan['agunan'] != $agunan->agunan) {
                    $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan agunan ' . $agunan->agunan . ' -> ' . $validatedDataAgunan['agunan'];
                }

                if ($validatedDataAgunan['ruang_agunan'] != $agunan->ruang_agunan) {
                    $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan ruang agunan ' . $agunan->ruang_agunan . ' -> ' . $validatedDataAgunan['ruang_agunan'];
                }

                if ($validatedDataAgunan['lemari_agunan'] != $agunan->lemari_agunan) {
                    $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan lemari _agunan ' . $agunan->lemari_agunan . ' -> ' . $validatedDataAgunan['lemari_agunan'];
                }

                if ($validatedDataAgunan['rak_agunan'] != $agunan->rak_agunan) {
                    $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan rak ' . $agunan->rak . ' -> ' . $validatedDataAgunan['rak_agunan'];
                }

                if ($validatedDataAgunan['baris_agunan'] != $agunan->baris_agunan) {
                    $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Perubahan baris ' . $agunan->baris . ' -> ' . $validatedDataAgunan['baris_agunan'];
                }
                $agunan->update([
                    'agunan' => $validatedDataAgunan['agunan'],
                    'ruang_agunan' => $validatedDataAgunan['ruang_agunan'],
                    'lemari_agunan' => $validatedDataAgunan['lemari_agunan'],
                    'ruang_agunan' => $validatedDataAgunan['ruang_agunan'],
                    'baris_agunan' => $validatedDataAgunan['baris_agunan'],
                ]);
                $berkas->update([
                    'agunan' => $validatedDataAgunan['agunan']
                ]);
            } else {
                $validatedDataAgunan = $request->validate([
                    'agunan' => 'required',
                    'lemari_agunan' => 'required|string',
                    'ruang_agunan' => 'required|integer',
                    'rak_agunan' => 'required|integer',
                    'baris_agunan' => 'required|integer',
                ]);

                $validatedDataAgunan['nama'] = $validatedData['nama'];
                $validatedDataAgunan['cif'] = $validatedData['cif'];
                $validatedDataAgunan['Lokasi'] = strval($berkas->lokasi);

                $riwayat['aktivitas'] = $riwayat['aktivitas'] . ' ' . '- Penambahan agunan ' . $validatedDataAgunan['agunan'];

                $recovery['agunan'] = $request->agunan;
                $recovery['ruang_agunan'] = $request->ruang_agunan;
                $recovery['lemari_agunan'] = $request->lemari_agunan;
                $recovery['rak_agunan'] = $request->rak_agunan;
                $recovery['baris_agunan'] = $request->baris_agunan;

                $berkas->agunan = $request->agunan;
                $berkas->save();

                Agunan::create($validatedDataAgunan);
            }
        }

        if ($request->jenis != "Kredit") {
            if ($agunan) {
                $berkas->agunan = null;
                $berkas->save();
                $agunan->delete();
            }
        }

        $newRecovery = Recovery::create($recovery);
        $riwayat['recovery_id'] = $newRecovery->id;
        Riwayat::create($riwayat);

        return redirect()->route('admin.berkas')->with('success', 'Perubahan dokumen ' . $berkas->nama . ' berhasil dilakukan');
    }

    public function konfirmasiPeminjaman($id)
    {
        $peminjaman = Pinjam::where('id', $id)->where('status', 'menunggu')->first();
        if ($peminjaman) {

            $peminjaman->status = 'dikonfirmasi';
            $peminjaman->update();

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Manajemen Peminjaman',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Konfirmasi peminjaman',
                'aktivitas' => session('role') . ' ' . session('name') . ' melakukan konfirmasi peminjaman ' . $peminjaman->user . ' dengan berkas ' . $peminjaman->nama,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('admin.viewBeranda')->with('success', 'Permintaan ' . $peminjaman->user . ' Berhasil dikonfirmasi');
        } else {
            return redirect()->route('admin.viewBeranda')->with('error', 'Konfirmasi tidak berhasil');
        }
    }

    public function tolakPeminjaman($id)
    {
        $peminjaman = Pinjam::where('id', $id)->where('status', 'menunggu')->first();
        $cif = $peminjaman->cif;
        $berkas = Berkas::where('cif', $cif)->first();

        if ($peminjaman) {

            $berkas->status = 'ada';
            $berkas->update();
            $peminjaman->status = 'ditolak';
            $peminjaman->update();

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Manajemen Peminjaman',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Menolak peminjaman',
                'aktivitas' => session('role') . ' ' . session('name') . ' menolak peminjaman ' . $peminjaman->user . ' dengan berkas ' . $peminjaman->nama,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('admin.viewBeranda')->with('success', 'Permintaan ' . $peminjaman->user . ' Berhasil ditolak');
        } else {
            return redirect()->route('admin.viewBeranda')->with('error', 'Konfirmasi tidak berhasil');
        }
    }

    public function konfirmasiPengembalian($id)
    {
        $pengembalian = Pengembalian::where('id', $id)->first();
        $cif = $pengembalian->cif;
        $peminjaman = Pinjam::where('cif', $cif)->first();
        $berkas = Berkas::where('cif', $cif)->first();

        if ($pengembalian) {

            $berkas->status = 'ada';
            $berkas->update();
            $pengembalian->status = 'dikonfirmasi';
            $pengembalian->update();
            $peminjaman->delete();

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Manajemen Peminjaman',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Konfirmasi pengembalian',
                'aktivitas' => session('role') . ' ' . session('name') . ' melakukan konfirmasi pengembalian ' . $peminjaman->user . ' dengan berkas ' . $peminjaman->nama,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('admin.viewBeranda')->with('success', 'Permintaan ' . $pengembalian->user . ' Berhasil dikonfirmasi');
        } else {
            return redirect()->route('admin.viewBeranda')->with('error', 'Konfirmasi tidak berhasil');
        }
    }

    public function tolakPengembalian($id)
    {
        $pengembalian = Pengembalian::where('id', $id)->first();

        $cif = $pengembalian->cif;
        $berkas = Berkas::where('cif', $cif)->first();
        $peminjaman = Pinjam::where('cif', $cif)->where('status', 'proses pengembalian')->first();

        if ($pengembalian) {

            $berkas->status = 'Tidak ada. Terakhir berada di ' . $pengembalian->user;
            $berkas->update();
            $pengembalian->status = 'ditolak';
            $pengembalian->update();
            $peminjaman->status = 'Dikonfirmasi';
            $peminjaman->update();

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Manajemen Peminjaman',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Menolak pengembalian',
                'aktivitas' => session('role') . ' ' . session('name') . ' menolak pengembalian ' . $peminjaman->user . ' dengan berkas ' . $peminjaman->nama,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('admin.viewBeranda')->with('success', 'Permintaan Pengambalian ' . $pengembalian->user . ' Berhasil ditolak');
        } else {
            return redirect()->route('admin.viewBeranda')->with('error', 'Penolakan tidak berhasil');
        }
    }

    public function viewRiwayat()
    {
        $riwayatstaff = Riwayat::latest()->where('role', 'User')->whereNull('recovery')->get();
        $riwayatAdmin = Riwayat::latest()->whereNull('recovery')->where('role', 'Admin')->get();
        $recovery = Riwayat::latest()->whereNotNull('recovery')->get();

        return view('admin.logaktivitas', compact('riwayatAdmin', 'riwayatstaff', 'recovery'));
    }

    public function recovery($id)
    {
        $recovery = Recovery::where('id', $id)->first();
        $berkas = Berkas::where('id', $recovery->berkas_id)->first();
        $agunan = Agunan::where('cif', $berkas->cif)->first();

        $newBerkas = [
            "nama" => $recovery->nama,
            "no_rek" => $recovery->no_rek,
            "cif" => $recovery->cif,
            'agunan' => $recovery->agunan,
            "jenis" => $recovery->jenis,
            "lokasi" => $recovery->lokasi,
            "ruang" => $recovery->ruang,
            "lemari" => $recovery->lemari,
            "rak" => $recovery->rak,
            "baris" => $recovery->baris,
        ];
        $berkas->update($newBerkas);

        if ($agunan) {
            if ($recovery->agunan) {
                $up = [
                    'lokasi' => $recovery->lokasi,
                    'ruang_agunan' => $recovery->ruang_agunan,
                    'lemari_agunan' => $recovery->lemari_agunan,
                    'rak_agunan' => $recovery->rak_agunan,
                    'baris_agunan' => $recovery->baris_agunan,
                ];
                $agunan->update($up);
            } else {
                $agunan->delete();
            }
        } else {
            if ($recovery->agunan) {
                $newAgunan = true;
            }
        }

        if (isset($newAgunan)) {
            $up = [
                "nama" => $recovery->nama,
                "cif" => $recovery->cif,
                'agunan' => $recovery->agunan,
                'Lokasi' => $recovery->lokasi,
                'ruang_agunan' => $recovery->ruang_agunan,
                'lemari_agunan' => $recovery->lemari_agunan,
                'rak_agunan' => $recovery->rak_agunan,
                'baris_agunan' => $recovery->baris_agunan,
            ];
            Agunan::create($up);
        }

        $device = Agent::browser() . ' ' . Agent::platform();

        $riwayat = [
            'kategori' => 'Recovery',
            'user' => session('name'),
            'role' => session('role'),
            'judul_aktivitas' => 'Recovery berkas ' . $berkas->nama,
            'aktivitas' => session('role') . ' ' . session('name') . ' melakukan recovery ' . $berkas->nama,
            'perangkat' => $device,
            'unit' => session('unit'),
        ];

        Riwayat::create($riwayat);

        return redirect()->route('admin.viewRiwayat')->with('success', 'Berhasil melakukan recovery');
    }

    // PROFILE

    public function viewProfile()
    {
        $user = User::where('id', session('uid'))->first();

        return view('admin.profile', compact('user'));
    }

    public function profileresetPassword()
    {
        return view('admin.resetpassword');
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

            return redirect()->route('admin.viewProfile')->with(['success' => 'Password berhasil diganti']);
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

            return redirect()->route('admin.viewProfile')->with(['success' => 'Informasi Profile berhasil diganti']);
        } else {
            return redirect()->back()->with(['error' => 'Password salah']);
        }
    }
}
