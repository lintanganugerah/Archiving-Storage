@extends('layout.admin.admlayout')
@section('content')

<div class="row">
    <div class="col">
        <div class="text-left mb-5">
            <h1 class="fw-medium">Log Aktivitas</h1>
            <h4 class="fw-normal">Pencatatan aktivitas yang dilakukan</h4>
        </div>
        <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
            <h4 id="judul-tabel-1" class="mb-3">Aktivitas Admin</h4>
            <table id="tabel" class="no-more-tables table text-dark table-striped table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Kategori</th>
                        <th>User</th>
                        <th class="w-75">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-title="Tanggal"><?php echo date("d/m/Y") ?></td>
                        <td data-title="Jam"><?php echo date("h:i:s") ?></td>
                        <td data-title="User">Data Berkas</td>
                        <td data-title="User">Dea</td>
                        <td data-title="Aktivitas" class="opacity-75">Melakukan perubahan Detail Berkas atas {nama Muhammad Hassanudin dengan CIF NZSA}.<br>{Nama Nasabah (Hasan->Hasun), Jenis (Kredit -> Lunas), No Rekening (757 -> 675)}
                        </td>
                    </tr>
                    <tr>
                        <td data-title="Tanggal">28/07/2023</td>
                        <td data-title="Jam">05:28:00</td>
                        <td data-title="User">Persetujuan Peminjaman</td>
                        <td data-title="User">Dea</td>
                        <td data-title="Aktivitas" class="opacity-75">Pengajuan Peminjaman oleh {user} telah disetujui dengan berkas atas nama {Hasrudin} dengan CIF {NZA}
                        </td>
                    </tr>
                    <tr>
                        <td data-title="Tanggal">28/07/2023</td>
                        <td data-title="Jam">05:28:00</td>
                        <td data-title="User">Tambah User</td>
                        <td data-title="User">Hasan</td>
                        <td data-title="Aktivitas" class="opacity-75">User atas nama {nama} telah dibuat dengan Role {role}
                        </td>
                    </tr>
                    <tr>
                        <td data-title="Tanggal">28/07/2023</td>
                        <td data-title="Jam">05:28:00</td>
                        <td data-title="User">Hapus User</td>
                        <td data-title="User">Hasan</td>
                        <td data-title="Aktivitas" class="opacity-75">Menghapus akun {nama} dengan Role {role}
                        </td>
                    </tr>
                    <tr>
                        <td data-title="Tanggal">27/07/2023</td>
                        <td data-title="Jam">07:28:00</td>
                        <td data-title="User">Ubah Role User</td>
                        <td data-title="User">Hasan</td>
                        <td data-title="Aktivitas" class="opacity-75">Mengubah Role {user} dari {role} menjadi {role}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-white p-4 rounded-3 mb-4" style="background-color: #0D3148;">
            <h4 id="judul-tabel-1" class="mb-3">Aktivitas Admin</h4>
            <table id="tabeluser" class="no-more-tables table text-dark table-striped table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Kategori</th>
                        <th>User</th>
                        <th class="w-75">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-title="Tanggal"><?php echo date("d/m/Y") ?></td>
                        <td data-title="Jam"><?php echo date("h:i:s") ?></td>
                        <td data-title="User">Data Berkas</td>
                        <td data-title="User">Dea</td>
                        <td data-title="Aktivitas" class="opacity-75">Melakukan perubahan {Detail Berkas atas nama Muhammad Hassanudin dengan No Rek 0757092123456}.{perubahan
                            yang dilakukan yaitu: Nama Nasabah, Jenis, No Rekening}
                        </td>
                    </tr>
                    <tr>
                        <td data-title="Tanggal">28/07/2023</td>
                        <td data-title="Jam">05:28:00</td>
                        <td data-title="User">Data Berkas</td>
                        <td data-title="User">Dea</td>
                        <td data-title="Aktivitas" class="opacity-75">Melakukan perubahan {Detail Berkas atas nama Muhammad Hassanudin dengan No Rek 0757092123456}.{perubahan
                            yang dilakukan yaitu: Nama Nasabah, Jenis, No Rekening}
                        </td>
                    </tr>
                    <tr>
                        <td data-title="Tanggal">28/07/2023</td>
                        <td data-title="Jam">05:28:00</td>
                        <td data-title="User">Data Berkas</td>
                        <td data-title="User">Hasan</td>
                        <td data-title="Aktivitas" class="opacity-75">Melakukan perubahan {Detail Berkas atas nama Muhammad Hassanudin dengan No Rek 0757092123456}.{perubahan
                            yang dilakukan yaitu: Nama Nasabah, Jenis, No Rekening}
                        </td>
                    </tr>
                    <tr>
                        <td data-title="Tanggal">27/07/2023</td>
                        <td data-title="Jam">07:28:00</td>
                        <td data-title="User">Login</td>
                        <td data-title="User">Hasan</td>
                        <td data-title="Aktivitas" class="opacity-75"> <span id="userAgentDisplay"></span> Pada Platform <span id="userPlatform"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    var userAgent = navigator.userAgent;
    var userPlatform = navigator.platform;

    // Menggunakan JavaScript untuk mengisi teks ke dalam elemen HTML
    
    document.getElementById('userPlatform').textContent = userPlatform;
    if (userAgent.includes('Chrome')) {
        document.getElementById('userAgentDisplay').textContent = 'Menggunakan browser Google Chrome.';
    } else if (userAgent.includes('Firefox')) {
        document.getElementById('userAgentDisplay').textContent = 'Menggunakan browser Mozilla Firefox.';
    } else if (userAgent.includes('Safari')) {
        document.getElementById('userAgentDisplay').textContent = 'Menggunakan browser Apple Safari.';
    } else if (userAgent.includes('Edge')) {
        document.getElementById('userAgentDisplay').textContent = 'Menggunakan browser Microsoft Edge.';
    } else {
        document.getElementById('userAgentDisplay').textContent = 'Menggunakan browser lain atau versi yang tidak dikenali.';
    }

    // Contoh lain: mendeteksi mobile browser
    if (userAgent.includes('Mobile')) {
        console.log('Menggunakan mobile browser.');
    } else {
        console.log('Menggunakan desktop browser.');
    }
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
            order: [
                [0, 'dsc']
            ],
            rowGroup: {
                dataSrc: 0
            }
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
                [0, 'dsc']
            ],
            rowGroup: {
                dataSrc: 0
            }
        });
    });
</script>
@endsection