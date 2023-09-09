@extends('layout.cabang.cblayout')
@section('content')

<div class="row">
    <div class="col">
        <div class="text-left mb-5 mt-3">
            <h1 class="fw-medium text-dark">Data Berkas</h1>
            <h4 class="fw-normal">Kumpulan data berkas</h4>
        </div>
        <!-- Modal Help Judul -->
        
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

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
                        <th>Unit</th>
                        <th>Aksi</th>
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
                        <td data-title="status">{{ $bk->lokasi }}</td>
                        <td data-title="aksi"><a href="{{ route('cabang.detailberkas', $bk->id) }}" class="btn btn-outline" id="aksi-{{$bk->id}}"><i class="fa-solid fa-info"></i></a></td>
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
                        <th>Unit</th>
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
                        <td data-title="Baris">{{ $ag->Lokasi }}</td>
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