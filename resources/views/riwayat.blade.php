@extends('layout.template')
@include('layout.navbar')
@section('content')

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
            <div class="text-left mb-5">
                <h1 class="fw-medium">Riwayat</h1>
                <h4 class="fw-normal">Pencatatan aktivitas berkas yang kamu lakukan</h4>
            </div>
            <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
                <table id="tabel" class="no-more-tables table table-striped table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Aktivitas</th>
                            <th>Nama Berkas</th>
                            <th>CIF Berkas</th>
                            <th>Rekening Berkas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-title="Tanggal"><?php echo date("d/m/Y") ?></td>
                            <td data-title="Jam"><?php echo date("h:i:s") ?></td>
                            <td data-title="Aktivitas">Pengajuan Pengembalian berkas</td>
                            <td data-title="Nama Berkas">Muhammad Hassanudin Sudarman</td>
                            <td data-title="CIF Berkas">NZXA21</td>
                            <td data-title="No Rek">07570101243201</td>
                        </tr>
                        <tr>
                            <td data-title="Tanggal"><?php echo date("d/m/Y") ?></td>
                            <td data-title="Jam"><?php echo date("h:i:s") ?></td>
                            <td data-title="Aktivitas">Pengajuan Pengembalian berkas</td>
                            <td data-title="Nama Berkas">Muhammad Hassanudin Sudarman</td>
                            <td data-title="CIF Berkas">NZXA21</td>
                            <td data-title="No Rek">07570101243201</td>
                        </tr>
                        <tr>
                            <td data-title="Tanggal"><?php echo date("d/m/Y") ?></td>
                            <td data-title="Jam"><?php echo date("h:i:s") ?></td>
                            <td data-title="Aktivitas">Pengajuan Pengembalian berkas</td>
                            <td data-title="Nama Berkas">Muhammad Hassanudin Sudarman</td>
                            <td data-title="CIF Berkas">NZXA21</td>
                            <td data-title="No Rek">07570101243201</td>
                        </tr>
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