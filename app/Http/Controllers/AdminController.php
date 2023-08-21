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

class AdminController extends Controller
{
    // Manajemen user
    public function viewBeranda()
    {
        $user = session('lokasi');
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

        

        return view('admin.beranda', compact('peminjaman', 'pengembalian', 'pengembalian2', 'data'));
    }
    
    public function viewUser()
    {
        $unit = session('lokasi');
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

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }

    public function editUserView(User $user)
    {
        $user = $user->first();

        return view('admin.useredit', compact('user'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $current = Auth::user();
        $user = User::find($id);

        if ($current->id == $user->id) {
            return redirect()->back()->with(['error' => 'Tidak dapat mengubah role sendiri']);
        } else {
            $user->update(['role' => $request->selected_role]); // Melakukan perubahan pada kolom "role"
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
        $user = Auth::user();
        $unit = intval($user->unit);
        // Simpan data berkas dan agunan ke database

        $berkas = new Berkas();
        $berkas->nama = $request->nama;
        $berkas->no_rek = $request->no_rek;
        $berkas->cif = $request->cif;
        if ($request->agunan) {
            $berkas->agunan = $request->agunan;
        }
        $berkas->jenis = $request->jenis;
        $berkas->Lokasi = $unit;
        $berkas->ruang = $request->ruang;
        $berkas->lemari = $request->lemari;
        $berkas->rak = $request->rak;
        $berkas->baris = $request->baris;
        $berkas->status = "ada";

        $berkas->save();

        // Redirect ke halaman tabel berkas atau halaman lainnya jika diperlukan
        return redirect('/admin/databerkas');
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

        if ($request->agunan) {
            if ($agunan) {
                $validatedDataAgunan = $request->validate([
                    'agunan' => 'required|string',
                    'ruang_agunan' => 'required|integer',
                    'lemari_agunan' => 'required|string',
                    'rak_agunan' => 'required|integer',
                    'baris_agunan' => 'required|integer',
                ]);
                $agunan->update([
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

                $berkas->agunan = $request->agunan;

                Agunan::create($validatedDataAgunan);
            }
        }


        $berkas->update([
            'nama' => $validatedData['nama'],
            'cif' => $validatedData['cif'],
            'jenis' => $validatedData['jenis'],
            'ruang' => $validatedData['ruang'],
            'lemari' => $validatedData['lemari'],
            'rak' => $validatedData['rak'],
            'baris' => $validatedData['baris'],
        ]);

        return redirect()->route('admin.berkas')->with('success', 'Perubahan dokumen ' . $berkas->nama . ' berhasil dilakukan');
    }

    public function konfirmasiPeminjaman($id)
    {
        $peminjaman = Pinjam::where('id', $id)->where('status', 'menunggu')->first();
        if ($peminjaman) {

            $peminjaman->status = 'dikonfirmasi';
            $peminjaman->update();

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

            return redirect()->route('admin.viewBeranda')->with('success', 'Permintaan Pengambalian ' . $pengembalian->user . ' Berhasil ditolak');
        } else {
            return redirect()->route('admin.viewBeranda')->with('error', 'Penolakan tidak berhasil');
        }
    }
    
}
