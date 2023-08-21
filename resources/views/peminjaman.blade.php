@extends('layout.template')
@include('layout.navbar')
@section('content')

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
            <div class="text-left mb-5">
                <h1 class="fw-medium">Peminjaman<a class="btn" data-bs-toggle="modal" data-bs-target="#helpModal"><i class="fa-solid fa-circle-question fa-lg" style="color: #0D3148;"></i></a></h1>
                <h4 class="fw-normal">Cari berkas mu disini. Nantinya akan diajukan ke admin untuk dilakukan persetujuan peminjaman</h4>
            </div>
            <!-- Modal Help Judul -->
            <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Bantuan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Pada halaman ini anda dapat meminjam berkas yang anda perlukan.
                            Baca selengkapnya dibawah
                            <p id="judul-tabel-1" class="mb-3 mt-2 fw-bold">Tata Cara</p>
                            <ol class="list-group">
                                <li class="list-group-item">
                                    <div class="fw-bold">Cara pinjam berkas?</div>
                                    Pilih kategori pencarian disamping bar pencarian, lalu cari berkas sesuai dengan kategori<p class="fw-bolder text-primary"> Disarankan untuk mencari menggunakan CIF </p>
                                </li>
                                <li class="list-group-item">
                                    <div class="fw-bold">Sistem peminjaman?</div>
                                    Klik "Pinjam" setelah menemukan berkas yang ingin dipinjam. Tunggu konfirmasi dari admin, lalu berkas akan masuk ke rak Anda.
                                </li>
                                <li class="list-group-item">
                                    <div class="fw-bold">Cara mengetahui proses status yang saya pinjam?</div>
                                    Pada halaman "Beranda", cek tabel "Permintaan Peminjaman" untuk melihat konfirmasi permintaan Anda.
                                    Jika disetujui, akan masuk ke "Peminjaman Aktif". Jika tidak, akan ada status "Tidak dapat dipinjam".
                                </li>
                                <li class="list-group-item text-danger fw-bold">Jangan lupa untuk mengembalikan berkas yang anda pinjam</li>
                            </ol>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Help Judul -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <div class="text-white p-4 rounded-3 mb-4 shadow" style="background-color: #14496C;">
                <form action="{{ route('user.reqPeminjaman') }}" method="POST" class="d-flex">
                    @csrf
                    <select class="form-select w-25" id="floatingSelect" aria-label="Floating label select example" name="opsi">
                        <option value="cif">CIF</option>
                        <option value="norek">Rekening</option>
                        <option value="nama">Nama</option>
                    </select>
                    <input type="text" class="form-control mx-2" id="floatingInput" name="search" placeholder="Cari Berkas">
                    <button type="submit" href="#aksi-#" class="btn btn-outline-light" id="aksi-#">Cari</button>
                </form>
            </div>
            <hr class="hr mt-5 mb-5" />
            <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
                <h4 id="judul-tabel-1" class="mb-3">Hasil Pencarian</h4>
                <table id="tabel" class="no-more-tables table text-dark table-sm table-light w-100 tabel-data" style="word-wrap: break-word;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Rekening</th>
                            <th>Nama</th>
                            <th>CIF</th>
                            <th>Jenis</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($berkas)
                        @foreach ($berkas as $bk)
                        <tr>
                            <td data-title="#">{{ $bk->id }}</td>
                            <td data-title="No Rek">{{ $bk->no_rek }}</td>
                            <td data-title="Nama">{{ $bk->nama }}</td>
                            <td data-title="CIF">{{ $bk->cif }}</td>
                            <td data-title="Jenis">{{ $bk->jenis }}</td>
                            <td data-title="Lokasi">{{ $bk->lokasi }}</td>
                            <td data-title="status">{{ $bk->status }}</td>
                            @if($bk->status!="ada")
                            <td data-title="aksi"><a class="btn btn-outline disabled" id="aksi-{{$bk->id}}">Pinjam</a></td>
                            @else
                            <td data-title="aksi"><a onclick="document.getElementById('update-form-{{ $bk->id }}').submit();" class="btn btn-outline" id="aksi-{{$bk->id}}">Pinjam</a></td>
                            <form id="update-form-{{ $bk->id }}" action="{{ route('user.attemptPinjam', $bk->id) }}" method="post" style="display: none;">
                                @csrf
                            </form>
                            @endif
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        const date = new Date();
        $('#tabel').DataTable({
            searching: false
        });
    });
    $(document).ready(() => {
        $("#kategori").val('2');
    });
</script>
@endsection