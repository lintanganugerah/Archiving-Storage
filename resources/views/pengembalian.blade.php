@extends('layout.template')
@include('layout.navbar')
@section('content')

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
            <div class="text-left mb-5">
                <h1 class="fw-medium">Pengembalian<a class="btn" data-bs-toggle="modal" data-bs-target="#helpModal"><i class="fa-solid fa-circle-question fa-lg" style="color: #0D3148;"></i></a></h1>
                <h4 class="fw-normal">Pilih berkas yang kamu pinjam sekarang untuk dikembalikan ke admin</h4>
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
                            Pada halaman ini anda dapat mengajukan permintaan pengembalian berkas yang telah anda pinjam.
                            Baca selengkapnya dibawah
                            <p id="judul-tabel-1" class="mb-3 mt-2 fw-bold">Tata Cara</p>
                            <ol class="list-group">
                                <li class="list-group-item">
                                    <div class="fw-bold">Cara pengembalian berkas?</div>
                                    Pilih berkas dari Pinjaman Aktif anda untuk dikembalikan<p class="fw-bolder text-primary"> Letakan berkas yang dikembalikan pada rak anda.</p>
                                </li>
                                <li class="list-group-item">
                                    <div class="fw-bold">Cara membatalkan peminjaman?</div>
                                    Pada halaman beranda, tekan tombol "Batalkan" di tabel permintaan pengembalian
                                </li>
                                <li class="list-group-item">
                                    <div class="fw-bold">Bagaimana jika saya tidak meletakan berkas pada rak saya?</div>
                                    Admin akan menolak permintaan pengembalian anda, dan berkas akan tetap Aktif
                                    dengan anda sebagai peminjam nya sampai berkas benar-benar dikembalikan.
                                </li>
                            </ol>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
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
            <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
                <table id="tabel" class="no-more-tables table table-striped table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Rek</th>
                            <th>Nama</th>
                            <th>CIF</th>
                            <th>Lokasi Berkas</th>
                            <th>Jenis</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($peminjamanAktif)
                        @foreach($peminjamanAktif as $pa)
                        <tr>
                            <td data-title="#">{{ $pa->id }}</td>
                            <td data-title="No Rek">{{ $pa->no_rek }}</td>
                            <td data-title="Nama">{{ $pa->nama }}</td>
                            <td data-title="CIF">{{ $pa->cif }}</td>
                            <td data-title="Lokasi Berkas">
                                {{ $pa->lokasi }}
                            </td>
                            <td data-title="Jenis">{{ $pa->jenis }}</td>
                            <td data-title="Catatan"><a href="#lihat-catatan-#" class="text-reset" id="lihat-catatan-#">Lihat catatan</a></td>
                            <td data-title="aksi">
                                <a onclick="document.getElementById('konfirmasi-pengembalian-{{ $pa->cif }}').submit();" class="btn btn-outline" id="aksi-{{$pa->cif}}">Kembalikan</a>
                            </td>
                            <form id="konfirmasi-pengembalian-{{ $pa->cif }}" action="{{ route('user.attemptPengembalian', $pa->cif) }}" method="post" style="display: none;">
                                @csrf
                            </form>
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
        $('#tabel').DataTable({});
    });
    $(document).ready(() => {
        $("#kategori").val('2');
    });
</script>
@endsection