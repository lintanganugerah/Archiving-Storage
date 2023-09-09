@extends('layout.admin.admlayout')
@section('content')

<div class="row">
    <div class="col">
        <div class="text-left mb-5 mt-3">
            <h1 class="fw-medium text-dark">Data Berkas<a class="btn" data-bs-toggle="modal" data-bs-target="#helpModal"><i class="fa-solid fa-circle-question fa-lg" style="color: #0D3148;"></i></a></h1>
            <h4 class="fw-normal">Manajemen Data Berkas disini</h4>
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
                        Pada halaman ini anda melakukan semua manajemen berkas. Setiap hal yang anda lakukan akan tercatat pada log aktivitas.
                        Baca selengkapnya dibawah
                        <p id="judul-tabel-1" class="mb-3 mt-2 fw-bold">Tata Cara</p>
                        <ol class="list-group">
                            <li class="list-group-item">
                                <div class="fw-bold">Saya ingin mencari berkas</div>
                                Gunakan fitur pencarian untuk menemukan berkas dengan cepat. <p class="fw-bolder text-primary"> Disarankan untuk mencari menggunakan CIF </p>
                            </li>
                            <li class="list-group-item">
                                <div class="fw-bold">Dimana Saya dapat melihat lokasi agunan?</div>
                                Terdapat tabel khusus untuk agunan
                            </li>
                            <li class="list-group-item">
                                <div class="fw-bold">Cara menambahkan berkas?</div>
                                Tekan tombol "Tambah Berkas Baru" untuk menambahkan berkas
                            </li>
                            <li class="list-group-item">
                                <div class="fw-bold">Kredit nasabah sudah lunas</div>
                                Tekan tombol pensil untuk melakukan perubahan dokumen. Disana anda dapat melakukan perubahan Jenis dokumen
                            </li>
                            <li class="list-group-item text-danger fw-bold">PERINGATAN! Data Tidak dapat dihapus pastikan untuk tidak memasukkan data palsu/tidak terdaftar</li>
                            <li class="list-group-item text-danger fw-bold">Setiap aktivitas perubahan yang anda lakukan akan tercatat di Log Aktivitas</li>
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
        <a href="{{ route('admin.createBerkas') }}" class="btn btn-outline-primary" id="aksi-#"><i class="fa-solid fa-file-circle-plus"></i> Tambah Berkas Baru</a>
        <div class="text-white p-4 rounded-3 mb-4 mt-4" style="background-color: #0D3148;">
            <h4 id="judul-tabel-1" class="mb-3">Berkas</h4>
            <table id="tabel" class="no-more-tables table text-dark table-sm table-light w-100 tabel-data" style="word-wrap: break-word;" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No Rek</th>
                        <th>Nama</th>
                        <th>CIF</th>
                        <th>Agunan</th>
                        <th>Jenis</th>
                        <th>Ruang</th>
                        <th>Lemari</th>
                        <th>Rak</th>
                        <th>Baris</th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($berkas as $key => $bk)
                    <tr>
                        <td data-title="#">{{ $key+1 }}</td>
                        <td data-title="No Rek">{{ $bk->no_rek }}</td>
                        <td data-title="Nama">{{ $bk->nama }}</td>
                        <td data-title="CIF">{{ $bk->cif }}</td>
                        <td data-title="Agunan">{{ $bk->agunan }}</td>
                        <td data-title="Jenis">{{ $bk->jenis }}</td>
                        <td data-title="Ruang">{{ $bk->ruang }}</td>
                        <td data-title="Lemari">{{ $bk->lemari }}</td>
                        <td data-title="Rak">{{ $bk->rak }}</td>
                        <td data-title="Baris">{{ $bk->baris }}</td>
                        <td data-title="status">{{ $bk->status }}</td>
                        <td data-title="aksi">
                            <a href="{{ route('admin.detailberkas', $bk->id) }}" class="btn btn-outline" id="info-{{$bk->id}}"><i class="fa-solid fa-info"></i></a>
                            <a href="{{ route('admin.editberkas', $bk->id) }}" class="btn btn-outline" id="aksi-{{$bk->id}}"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-white p-4 rounded-3 mb-4 mt-4" style="background-color: #0D3148;">
            <h4 id="judul-tabel-1" class="mb-3">Cari Agunan</h4>
            <table id="tabel" class="no-more-tables table text-dark table-sm table-light w-100 tabel-data" style="word-wrap: break-word;" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>CIF</th>
                        <th>Agunan</th>
                        <th>Ruang Agunan</th>
                        <th>Lemari Agunan</th>
                        <th>Rak Agunan</th>
                        <th>Baris Agunan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agunan as $ag)
                    <tr>
                        <td data-title="#">{{ $ag->id }}</td>
                        <td data-title="Nama">{{ $ag->nama }}</td>
                        <td data-title="CIF">{{ $ag->cif }}</td>
                        <td data-title="Agunan">{{ $ag->agunan }}</td>
                        <td data-title="Ruang">{{ $ag->ruang_agunan }}</td>
                        <td data-title="Lemari">{{ $ag->lemari_agunan }}</td>
                        <td data-title="Rak">{{ $ag->rak_agunan }}</td>
                        <td data-title="Baris">{{ $ag->baris_agunan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        const date = new Date();
        $('.tabel-data').DataTable({
            lengthMenu: [
                [3, 5, 10, 25, -1],
                [3, 5, 10, 25, 'All']
            ],
            // fixedHeader: true,
            // order: [
            //   [6, 'asc']
            // ],
            // rowGroup: {
            //   dataSrc: 6
            // }
        });
    });
</script>
@endsection