<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Berkas;
use App\Models\Agunan;
use App\Models\Pinjam;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengembalian;
use Faker\Provider\UserAgent;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Facades\Agent;

class UserController extends Controller
{
    public function viewPeminjaman()
    {
        $berkas = null;
        return view('peminjaman', compact('berkas'));
    }

    public function viewPengembalian()
    {
        $peminjamanAktif = Pinjam::where('user', session('name'))
            ->where('status', 'dikonfirmasi')
            ->get();
        return view('pengembalian', compact('peminjamanAktif'));
    }

    public function viewHome()
    {
        $user = session('name');
        $peminjaman = Pinjam::where('user', $user)->get();
        $pengembalian = Pengembalian::where('user', $user)->get();
        $peminjamanAktif = Pinjam::where('user', $user)
            ->where('status', 'dikonfirmasi')
            ->get();



        return view('home', compact('peminjaman', 'peminjamanAktif', 'pengembalian'));
    }

    public function viewProfile()
    {
        $user = User::where('id', session('uid'))->first();

        return view('profile', compact('user'));
    }

    public function resetPassword()
    {
        return view('resetpassword');
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
                'kategori' => 'User',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'User melakukan perubahan profile',
                'aktivitas' => session('name') . ' mengubah password akun pada perangkat ' . $device,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('user.viewProfile')->with(['success' => 'Password berhasil diganti']);
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

            return redirect()->route('user.viewProfile')->with(['success' => 'Informasi Profile berhasil diganti']);
        } else {
            return redirect()->back()->with(['error' => 'Password salah']);
        }
    }

    public function requestPeminjaman(Request $request)
    {
        $search = $request->search;
        $lokasi = session('unit');
        if ($request->opsi == 'cif') {
            $berkas = Berkas::whereRaw('LOWER(cif) LIKE ? AND LOWER(lokasi) LIKE ?', [
                '%' . strtolower($search) . '%',
                '%' . strtolower($lokasi) . '%'
            ])->get();
        } else if ($request->opsi == 'norek') {
            $berkas = Berkas::whereRaw('LOWER(no_rek) LIKE ? AND LOWER(lokasi) LIKE ?', [
                '%' . strtolower($search) . '%',
                '%' . strtolower($lokasi) . '%'
            ])->get();
        } else if ($request->opsi == 'nama') {
            $berkas = Berkas::whereRaw('LOWER(nama) LIKE ? AND LOWER(lokasi) LIKE ?', [
                '%' . strtolower($search) . '%',
                '%' . strtolower($lokasi) . '%'
            ])->get();
        } else {
            return redirect()->back()->with(['error' => 'Pencarian tidak valid']);
        }

        // $berkas = Berkas::find($id);
        // $cif = $berkas->cif;
        // $agunan = Agunan::where("cif", $cif)->first();

        return view('peminjaman', compact('berkas', 'search'));
    }

    public function attemptPeminjaman($id)
    {
        $berkas = Berkas::where('id', $id)->first();
        $duplikat = Pinjam::where('nama', $berkas->nama)->where('status', 'ditolak')->first();

        if ($berkas->status = "ada") {
            if ($duplikat) {
                $duplikat->delete();
            }

            $batch = [
                'no_rek' => $berkas->no_rek,
                'nama' => $berkas->nama,
                'cif' => $berkas->cif,
                'jenis' => $berkas->jenis,
                'lokasi' => $berkas->lokasi,
                'lemari' => $berkas->lemari,
                'rak' => $berkas->rak,
                'baris' => $berkas->baris,
                'status' => 'menunggu',
                'user' => session('name')
            ];

            $berkas->status = 'Dipinjam oleh ' . session('name');
            $berkas->update();

            Pinjam::create($batch);

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Peminjaman',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Mengajukan peminjaman',
                'aktivitas' => session('name') . ' melakukan pengajuan peminjaman berkas ' . $berkas->nama,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            // $berkas = Berkas::find($id);
            // $cif = $berkas->cif;
            // $agunan = Agunan::where("cif", $cif)->first();

            return redirect()->route('user.viewPeminjaman')->with('success', 'Pengajuan berhasil. Silahkan pantau pengajuan pada halaman Beranda');
        } else {
            return redirect()->route('user.viewPeminjaman')->with('error', 'Pengajuan gagal, berkas tidak dapat dipinjam');
        }
    }

    public function batalkanPeminjaman($id)
    {
        $peminjaman = Pinjam::where('id', $id)->first();
        $cif = $peminjaman->cif;
        $berkas = Berkas::where('cif', $cif)->first();
        if ($berkas) {

            $berkas->status = 'ada';
            $berkas->update();

            $peminjaman->delete();

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Peminjaman',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Membatalkan peminjaman',
                'aktivitas' => session('name') . ' melakukan pembatalan peminjaman berkas ' . $berkas->nama,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('user.viewHome')->with('success', 'Dokumen ' . $berkas->nama . ' Berhasil dibatalkan');
        } else {
            return redirect()->route('user.viewHome')->with('error', 'Pembatalan tidak berhasil');
        }
    }

    public function attemptPengembalian($id)
    {
        $peminjaman = Pinjam::where('cif', $id)->first();
        $pengembalian = Pengembalian::where('cif', $id)->where('status', 'ditolak')->first();

        if ($peminjaman->status = "dikonfirmasi") {
            if ($pengembalian != null) {
                $peminjaman->status = "proses pengembalian";
                $peminjaman->update();
                $pengembalian->status = "menunggu 2";
                $pengembalian->update();
            } else {
                $batch = [
                    'no_rek' => $peminjaman->no_rek,
                    'nama' => $peminjaman->nama,
                    'cif' => $peminjaman->cif,
                    'jenis' => $peminjaman->jenis,
                    'lokasi' => $peminjaman->lokasi,
                    'status' => 'menunggu',
                    'user' => session('name')
                ];

                Pengembalian::create($batch);
                $peminjaman->status = "proses pengembalian";
                $peminjaman->update();

                // $berkas = Berkas::find($id);
                // $cif = $berkas->cif;
                // $agunan = Agunan::where("cif", $cif)->first();
            }
            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Pengembalian',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Mengajukan pengembalian',
                'aktivitas' => session('name') . ' melakukan pengajuan pengembalian berkas ' . $peminjaman->nama,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('user.viewPengembalian')->with('success', 'Pengajuan berhasil. Silahkan pantau pengajuan pada halaman Beranda');
        } else {
            return redirect()->route('user.viewPengembalian')->with('error', 'Pengajuan gagal, berkas gagal ditemukan');
        }
    }

    public function batalkanPengembalian($id)
    {
        $pengembalian = Pengembalian::where('id', $id)->first();
        $cif = $pengembalian->cif;
        $peminjaman = Pinjam::where('cif', $cif)->where('status', 'proses pengembalian')->first();
        if ($pengembalian) {

            $peminjaman->status = 'Dikonfirmasi';
            $peminjaman->update();
            $pengembalian->delete();

            $device = Agent::browser() . ' ' . Agent::platform();

            $riwayat = [
                'kategori' => 'Pengembalian',
                'user' => session('name'),
                'role' => session('role'),
                'judul_aktivitas' => 'Membatalkan pengembalian',
                'aktivitas' => session('name') . ' membatalkan pengembalian berkas ' . $peminjaman->nama,
                'perangkat' => $device,
                'unit' => session('unit'),
            ];

            Riwayat::create($riwayat);

            return redirect()->route('user.viewHome')->with('success', 'Pengembalian dokumen ' . $pengembalian->nama . ' Berhasil dibatalkan');
        } else {
            return redirect()->route('user.viewHome')->with('error', 'Pembatalan tidak berhasil');
        }
    }

    public function viewRiwayat()
    {
        $riwayat = Riwayat::where('user', session('name'))->latest()->get();
        $riwayatAll = Riwayat::latest()->get();

        return view('riwayat', compact('riwayat', 'riwayatAll'));
    }


    public function catatanUpdate(Request $request, $id)
    {
        $note = Pinjam::where('id', $id)->first();

        if ($request->content) {
            if ($request->content == $note->catatan){
                return redirect()->route('user.viewHome');
            }
            $note->catatan = $request->content;
            $note->save();
        } else {
            if ($request->content == $note->catatan){
                return redirect()->route('user.viewHome');
            }
            $note->catatan = null;
            $note->save();
        }

        return redirect()->route('user.viewHome')->with('success', 'Catatan berhasil diperbarui');
    }
}
