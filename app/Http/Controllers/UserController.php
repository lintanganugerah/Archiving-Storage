<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Berkas;
use App\Models\Agunan;
use App\Models\Pinjam;
use App\Models\Pengembalian;

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

    public function requestPeminjaman(Request $request)
    {
        $search = $request->search;
        $lokasi = session('lokasi');
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
        if ($berkas->status = "ada") {

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
                return redirect()->route('user.viewPengembalian')->with('success', 'Pengajuan berhasil. Silahkan pantau pengajuan pada halaman Beranda');
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

                return redirect()->route('user.viewPengembalian')->with('success', 'Pengajuan berhasil. Silahkan pantau pengajuan pada halaman Beranda');
            }
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

            return redirect()->route('user.viewHome')->with('success', 'Pengembalian dokumen ' . $pengembalian->nama . ' Berhasil dibatalkan');
        } else {
            return redirect()->route('user.viewHome')->with('error', 'Pembatalan tidak berhasil');
        }
    }
}
