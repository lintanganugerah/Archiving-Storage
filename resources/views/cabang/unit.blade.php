@extends('layout.cabang.cblayout')
@section('content')

<div class="row">
    <div class="col">
        <div class="text-left mb-5 mt-3">
            <h1 class="fw-medium text-dark">Unit</h1>
        </div>
        <!-- Modal Help Judul -->
        
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <a href="{{ route('cabang.createUnit') }}" class="btn btn-outline-primary" id="aksi-#"><i class="fa-solid fa-square-plus"></i> Tambah Unit Baru</a>
        <div class="text-white p-4 rounded-3 mb-4 mt-4" style="background-color: #0D3148;">
            <h4 id="judul-tabel-1" class="mb-3">Berkas</h4>
            <table id="tabel" class="no-more-tables table text-dark table-sm table-light w-100 tabel-data" style="word-wrap: break-word;" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Unit</th>
                        <th>Kode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unit as $key => $u)
                    <tr>
                        <td data-title="#">{{ $key+1 }}</td>
                        <td data-title="Unit">{{ $u->unit }}</td>
                        <td data-title="Kode">{{ $u->kode }}</td>
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
                [10, 15, 20, 25, -1],
                [10, 15, 20, 25, 'All']
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