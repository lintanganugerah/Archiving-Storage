@extends('layout.cabang.cblayout')
@section('content')

<div class="row">
    <div class="col">
        <div class="text-left mb-5">
            <h1 class="fw-medium">Log Aktivitas</h1>
            <h4 class="fw-normal">Pencatatan aktivitas yang dilakukan</h4>
        </div>

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
            <h4 id="judul-tabel-1" class="mb-3">Aktivitas admin cabang anda</h4>
            <table id="tabel" class="no-more-tables table text-dark table-striped table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th class="w-50">Detail Aktivitas</th>
                        <th>Unit</th>
                        <th>Tanggal & Waktu (WIB)</th>
                    </tr>
                </thead>
                <tbody>
                    @if($riwayat)
                    @foreach($riwayat as $key => $rn)
                    <tr>
                        <td data-title="#">{{ $key + 1 }}</td>
                        <td data-title="Kategori">{{ $rn->kategori }}</td>
                        <td data-title="User">{{ $rn->user }}</td>
                        <td data-title="Aktivitas">{{ $rn->judul_aktivitas }}</td>
                        <td data-title="Detail Aktivitas">{{ $rn->aktivitas }}</td>
                        <td data-title="Unit">{{ $rn->unit }}</td>
                        <td data-title="Tanggal & Waktu (WIB)">{{ $rn->created_at }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        
        <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
            <h4 id="judul-tabel-1" class="mb-3">Aktivitas admin unit anda</h4>
            <table id="tabeluser" class="no-more-tables table text-dark table-striped table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th class="w-50">Detail Aktivitas</th>
                        <th>Unit</th>
                        <th>Tanggal & Waktu (WIB)</th>
                    </tr>
                </thead>
                <tbody>
                    @if($riwayatAdmin)
                    @foreach($riwayatAdmin as $key => $r)
                    <tr>
                        <td data-title="#">{{ $key + 1 }}</td>
                        <td data-title="Kategori">{{ $r->kategori }}</td>
                        <td data-title="User">{{ $r->user }}</td>
                        <td data-title="Aktivitas">{{ $r->judul_aktivitas }}</td>
                        <td data-title="Detail Aktivitas">{{ $r->aktivitas }}</td>
                        <td data-title="Unit">{{ $r->unit }}</td>
                        <td data-title="Tanggal & Waktu (WIB)">{{ $r->created_at }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
            <h4 id="judul-tabel-1" class="mb-3">Aktivitas staff unit</h4>
            <table id="tabelberkas" class="no-more-tables table table-striped table-sm table-light data w-100" style="word-wrap: break-word;" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Detail Aktivitas</th>
                        <th>Unit</th>
                        <th>Tanggal & Waktu (WIB)</th>
                    </tr>
                </thead>
                <tbody>
                    @if($riwayatstaff)
                    @foreach($riwayatstaff as $key => $rec)
                    <tr>
                        <td data-title="#">{{ $key + 1 }}</td>
                        <td data-title="Kategori">{{ $rec->kategori }}</td>
                        <td data-title="User">{{ $rec->user }}</td>
                        <td data-title="Aktivitas">{{ $rec->judul_aktivitas }}</td>
                        <td data-title="Detail Aktivitas">{{ $rec->aktivitas }}</td>
                        <td data-title="Unit">{{ $rec->unit }}</td>
                        <td data-title="Tanggal & Waktu (WIB)">{{ $rec->created_at }}</td>
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
        $('#tabel').DataTable({
            lengthMenu: [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, 'All']
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: 'Excel',
                    title: "Log Aktivitas Admin",
                    messageTop: "Dicetak pada : " + date,
                    filename: "Log Aktivitas Admin" + date
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: "Log Aktivitas Admin",
                    messageTop: "Dicetak pada : " + date,
                    filename: "Log Aktivitas Admin" + date
                },
                {
                    extend: 'print',
                    text: 'Print',
                    title: "Log Aktivitas Admin",
                    messageTop: "Dicetak pada : " + date,
                    filename: "Log Aktivitas Admin" + date
                }, 'pageLength',
            ],
            fixedHeader: true,
        });
    });
    $(document).ready(function() {
        const date = new Date();
        $('#tabeluser').DataTable({
            lengthMenu: [
                [10, 20, 30, 40, -1],
                [10, 20, 30, 40, 'All']
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: 'Excel',
                    title: "Log Aktivitas User",
                    messageTop: "Dicetak oleh admin pada : " + date,
                    filename: "Log Aktivitas User" + date
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: "Log Aktivitas User",
                    messageTop: "Dicetak oleh admin pada " + date,
                    filename: "Log Aktivitas User" + date
                },
                {
                    extend: 'print',
                    text: 'Print',
                    title: "Log Aktivitas User",
                    messageTop: "Dicetak admin pada : " + date,
                    filename: "Log Aktivitas User" + date
                }, 'pageLength',
            ],
            fixedHeader: true,
            order: [
                [0, 'asc']
            ],
            rowGroup: {
                dataSrc: 5
            }
        });
    });
    $(document).ready(function() {
        const date = new Date();
        $('#tabelberkas').DataTable({
            lengthMenu: [
                [10, 20, 30, 40, -1],
                [10, 20, 30, 40, 'All']
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: 'Excel',
                    title: "Log Aktivitas User",
                    messageTop: "Dicetak oleh admin pada : " + date,
                    filename: "Log Aktivitas User" + date
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: "Log Aktivitas User",
                    messageTop: "Dicetak oleh admin pada " + date,
                    filename: "Log Aktivitas User" + date
                },
                {
                    extend: 'print',
                    text: 'Print',
                    title: "Log Aktivitas User",
                    messageTop: "Dicetak admin pada : " + date,
                    filename: "Log Aktivitas User" + date
                }, 'pageLength',
            ],
            fixedHeader: true,
            order: [
                [0, 'asc']
            ],
            rowGroup: {
                dataSrc: 5
            }
        });
    });
</script>
@endsection