@extends('layout.template')
@include('layout.navbar')
@section('content')

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
            <div class="text-left mb-5">
                <h1 class="fw-medium">Riwayat</h1>
                <h4 class="fw-normal">Pencatatan aktivitas yang pernah dilakukan</h4>
            </div>
            <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
                <h4 id="judul-tabel-1" class="mb-3">Riwayat aktivitas anda</h4>
                <table id="tabel" class="no-more-tables table table-striped table-sm data table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>User</th>
                            <th>Aktivitas</th>
                            <th>Detail Aktivitas</th>
                            <th>Tanggal & Waktu (WIB)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($riwayat)
                        @foreach($riwayat as $key => $r)
                        <tr>
                            <td data-title="#">{{ $key + 1 }}</td>
                            <td data-title="Kategori">{{ $r->kategori }}</td>
                            <td data-title="User">{{ $r->user }}</td>
                            <td data-title="Aktivitas">{{ $r->judul_aktivitas }}</td>
                            <td data-title="Detail Aktivitas">{{ $r->aktivitas }}</td>
                            <td data-title="Tanggal & Waktu (WIB)">{{ $r->created_at }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
                <h4 id="judul-tabel-1" class="mb-3">Riwayat aktivitas unit anda</h4>
                <table id="tabel" class="no-more-tables table table-striped table-sm table-light data w-100" style="word-wrap: break-word;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>User</th>
                            <th>Aktivitas</th>
                            <th>Detail Aktivitas</th>
                            <th>Tanggal & Waktu (WIB)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($riwayatAll)
                        @foreach($riwayatAll as $key => $ra)
                        <tr>
                            <td data-title="#">{{ $key + 1 }}</td>
                            <td data-title="Kategori">{{ $ra->kategori }}</td>
                            <td data-title="User">{{ $ra->user }}</td>
                            <td data-title="Aktivitas">{{ $ra->judul_aktivitas }}</td>
                            <td data-title="Detail Aktivitas">{{ $ra->aktivitas }}</td>
                            <td data-title="Tanggal & Waktu (WIB)">{{ $ra->created_at }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const date = new Date();
            $('.data').DataTable({
                lengthMenu: [
                    [10, 20, 30, 40, -1],
                    [10, 20, 30, 40, 'All']
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        text: 'Excel',
                        title: "Riwayat Aktivitas {user}",
                        messageTop: date,
                        filename: "Riwayat Aktivitas {user}"
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: "Riwayat Aktivitas {user}",
                        messageTop: date,
                        filename: "Riwayat Aktivitas {user}"
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        title: "Riwayat Aktivitas {user}",
                        messageTop: date,
                        filename: "Riwayat Aktivitas {user}"
                    }, 'pageLength',
                ]
            });
        });
    </script>
</div>
@endsection