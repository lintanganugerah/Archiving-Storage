@extends('layout.template')
@include('layout.navbar')
@section('content')

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
            <div class="text-left mb-5">
                <h1 class="fw-bold">Hai, <a href="{{ route('user.viewprofile') }}" class="text-reset">{{ session('name') }}!</a></h1>
                <h4 class="fw-normal">Yuk cek berkas yang masih kamu pinjam, jangan lupa dikembalikan ya!</h4>
            </div>
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
            @endif
            <div class="text-white p-4 rounded-3 mb-4 shadow" style="background-color: #14496C;">
                <div class="row d-flex">
                    <div class="col-md-6 d-flex align-items-center justify-items-center">
                        <div class="">Berkas apa yang ingin kamu cari?</div>
                    </div>
                    <div id="button-card-search" class="col-md-6 d-flex me-auto">
                        <a href="{{ route('user.viewPeminjaman') }}" class="btn btn-outline-light" style="border-color: #D4E9F7;">Cari Berkas</a>
                    </div>
                </div>
            </div>
            <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
                <h4 id="judul-tabel-1" class="mb-3">Tabel Pinjaman Aktif</h4>
                <table id="tabel-peminjaman-aktif-1" class="no-more-tables table table-striped table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Rek</th>
                            <th>Nama</th>
                            <th>CIF</th>
                            <th>Lokasi Berkas</th>
                            <th>Jenis</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($peminjamanAktif)
                        @foreach($peminjamanAktif as $key => $pa)
                        <tr>
                            <td data-title="#">{{ $key+1 }}</td>
                            <td data-title="No Rek">{{ $pa->no_rek }}</td>
                            <td data-title="Nama">{{ $pa->nama }}</td>
                            <td data-title="CIF">{{ $pa->cif }}</td>
                            <td data-title="Lokasi Berkas">
                                {{ $pa->lokasi }}
                            </td>
                            <td data-title="Jenis">{{ $pa->jenis }}</td>
                            <td data-title="Catatan"><a class="text-decoration-underline text-reset" data-bs-toggle="modal" data-bs-target="#catatan-modal-{{ $pa->id }}">Lihat catatan</a></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if($peminjamanAktif)
            @foreach($peminjamanAktif as $pa)
            <div class="modal fade" id="catatan-modal-{{ $pa->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Catatan Berkas {{ $pa->nama }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk mengisi catatan -->
                            <form method="POST" id="catatan-{{ $pa->id }}" action="{{ route('user.catatanUpdate', $pa->id) }}">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control" name="content" rows="5">{{ $pa->catatan }}</textarea>
                                </div>
                            </form>
                        </div>

                        <!-- Footer modal -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" onclick="document.getElementById('catatan-{{ $pa->id }}').submit();" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
                <h4 id="judul-tabel-2" class="mb-3">Pengajuan Pengembalian</h4>
                <table id="tabel-peminjaman-aktif-2" class="no-more-tables table table-striped table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Rek</th>
                            <th>Nama</th>
                            <th>CIF</th>
                            <th>Lokasi Berkas</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pengembalian)
                        @foreach($pengembalian as $key => $pg)
                        <tr>
                            @if ($pg->status != 'dikonfirmasi')
                            <td data-title="#">{{ $key+1 }}</td>
                            <td data-title="No Rek">{{ $pg->no_rek }}</td>
                            <td data-title="Nama">{{ $pg->nama }}</td>
                            <td data-title="CIF">{{ $pg->cif }}</td>
                            <td data-title="Lokasi Berkas">{{ $pg->lokasi }} </td>
                            @if ( $pg->status == 'menunggu' )
                            <td data-title="Jenis">{{ $pg->jenis }}</td>
                            <td data-title="aksi"><a onclick="document.getElementById('batalkan-form-{{ $pg->id }}').submit();" class="btn btn-outline" id="aksi-{{$pg->id}}">Batalkan</a></td>
                            <form id="batalkan-form-{{ $pg->id }}" action="{{ route('user.batalkanPengembalian', ['id' => $pg->id, 'cif' => $pg->cif]) }}" method="post" style="display: none;">
                                @csrf
                            </form>
                            @elseif ( $pg->status == 'menunggu 2' )
                            <td data-title="Jenis">{{ $pg->jenis }}</td>
                            <td data-title="aksi">Mohon menunggu konfirmasi</td>
                            @else
                            <td data-title="Jenis">{{ $pg->jenis }}</td>
                            <td data-title="Aksi">Berkas tidak ada pada rak pengembalian. Mohon cari berkas tersebut</td>
                            @endif
                            @endif
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
                <h4 id="judul-tabel-2" class="mb-3">Pinjaman menunggu persetujuan</h4>
                <table id="tabel-peminjaman-aktif-2" class="no-more-tables table table-striped table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Rek</th>
                            <th>Nama</th>
                            <th>CIF</th>
                            <th>Lokasi Berkas</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($peminjaman)
                        @foreach($peminjaman as $key => $p)
                        <tr>
                            @if ($p->status == 'ditolak' || $p->status == 'menunggu')
                            <td data-title="#">{{ $key+1 }}</td>
                            <td data-title="No Rek">{{ $p->no_rek }}</td>
                            <td data-title="Nama">{{ $p->nama }}</td>
                            <td data-title="CIF">{{ $p->cif }}</td>
                            <td data-title="Lokasi Berkas">{{ $p->lokasi }} </td>
                            @if ( $p->status == 'menunggu' )
                            <td data-title="Jenis">{{ $p->jenis }}</td>
                            <td data-title="aksi"><a onclick="document.getElementById('batalkan-form-{{ $p->id }}').submit();" class="btn btn-outline" id="aksi-{{$p->id}}">Batalkan</a></td>
                            <form id="batalkan-form-{{ $p->id }}" action="{{ route('user.batalkanPinjam', ['id' => $p->id, 'cif' => $p->cif]) }}" method="post" style="display: none;">
                                @csrf
                            </form>
                            @else
                            <td data-title="Jenis">{{ $p->jenis }}</td>
                            <td data-title="Aksi">Tidak dapat dipinjam</td>
                            @endif
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
        $('#tabel-peminjaman-aktif-1').DataTable({
            lengthMenu: [
                [3, 5, 10, 25, -1],
                [3, 5, 10, 25, 'All']
            ],
            // dom: 'Bfrtip',
            // buttons: [{
            //         extend: 'excel',
            //         text: 'Excel',
            //         title: "Tabel Pinjaman Aktif {user}",
            //         messageTop: date,
            //         messageBottom: "Jika berkas sudah tidak digunakan lagi. Mohon kembalikan berkas melalui menu 'Pengembalian'",
            //         filename: "Pinjaman Aktif {user}"
            //     },
            //     {
            //         extend: 'pdf',
            //         text: 'PDF',
            //         title: "Tabel Pinjaman Aktif {user}",
            //         messageTop: date,
            //         messageBottom: "Jika berkas sudah tidak digunakan lagi. Mohon mengembalikan berkas melalui menu 'Pengembalian'",
            //         filename: "Pinjaman Aktif {user}"
            //     },
            //     {
            //         extend: 'print',
            //         text: 'Print',
            //         title: "Tabel Pinjaman Aktif {user}",
            //         messageTop: date,
            //         messageBottom: "Jika berkas sudah tidak digunakan lagi. Mohon mengembalikan berkas melalui menu 'Pengembalian'",
            //         filename: "Pinjaman Aktif {user}"
            //     }, 'pageLength',
            // ]
        });
    });
</script>

@endsection