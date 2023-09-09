@extends('layout.admin.admlayout')
@section('content')

<div class="row">
  <div class="col">
    <div class="text-left mb-5 mt-3">
      <h1 class="fw-medium text-dark">Beranda</h1>
      <h5 class="text-dark">Anda login sebagai {{ session('unit') }} Admin <a href="{{ route('admin.viewProfile') }}" class="text-reset"><u>{{ session('name') }}!</u></a></h5>
    </div>

    <div class="row gx-5">

      <!-- Earnings (Monthly) Card Example -->
      <div class="col mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                  Permintaan Pinjam</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['peminjaman'] }}</div>
              </div>
              <div class="col-auto test" id="icon-beranda-1">
                <i class="fas fa-file-export fa-2x text-gray-400"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                  Permintaan Pengembalian</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['pengembalian'] }}</div>
              </div>
              <div class="col-auto" id="icon-beranda-2">
                <i class="fas fa-file-import fa-2x text-gray-400"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Berkas (Tersedia)
                </div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $data['allberkas'] }}</div>
                  </div>
                </div>
              </div>
              <div class="col-auto" id="icon-beranda-3">
                <i class="fas fa-file-circle-check fa-2x text-gray-400"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pending Requests Card Example -->
      <div class="col mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                  Total Berkas (Dipinjam)</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['dipinjam'] }}</div>
              </div>
              <div class="col-auto" id="icon-beranda-4">
                <i class="fas fa-file-circle-exclamation fa-2x text-gray-400"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      </button>
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
    </div>
    @endif

    <div class="text-white p-4 rounded-3 mb-4 mt-4" style="background-color: #0D3148;">
      <h4 id="judul-tabel-1" class="mb-3">Permintaan Pinjam</h4>
      <table id="tabel" class="no-more-tables table text-dark table-sm table-light w-100 tabel-data" style="word-wrap: break-word;" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>No Rek</th>
            <th>Nama</th>
            <th>CIF</th>
            <th>Lokasi Berkas</th>
            <th>Jenis</th>
            <th>User</th>
            <th>Lemari</th>
            <th>Rak</th>
            <th>Baris</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @if($peminjaman)
          @foreach($peminjaman as $key => $p)
          <tr>
            <td data-title="#">{{ $key + 1 }}</td>
            <td data-title="No Rek">{{ $p->no_rek }}</td>
            <td data-title="Nama">{{ $p->nama }}</td>
            <td data-title="CIF">{{ $p->cif }}</td>
            <td data-title="Lokasi Berkas">{{ $p->lokasi }} </td>
            <td data-title="Jenis">{{ $p->jenis }}</td>
            <td data-title="User">{{ $p->user }}</td>
            <td data-title="Lemari">{{ $p->lemari }}</td>
            <td data-title="Rak">{{ $p->rak }}</td>
            <td data-title="Baris">{{ $p->baris }}</td>
            <td data-title="aksi">
              <a onclick="document.getElementById('konfirmasi-form-{{ $p->id }}').submit();" class="btn btn-outline" id="aksi-{{$p->id}}">Konfirmasi</a>
              <a onclick="document.getElementById('tolak-form-{{ $p->id }}').submit();" class="btn btn-outline-danger" id="aksi-{{$p->id}}">Tolak</a>
            </td>
            <form id="konfirmasi-form-{{ $p->id }}" action="{{ route('user.konfirmasiPinjam', $p->id) }}" method="post" style="display: none;">
              @csrf
            </form>
            <form id="tolak-form-{{ $p->id }}" action="{{ route('user.tolakPinjam', $p->id) }}" method="post" style="display: none;">
              @csrf
            </form>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
    <div class="text-white p-4 rounded-3 mb-4 mt-4" style="background-color: #0D3148;">
      <h4 id="judul-tabel-1" class="mb-3">Permintaan Pengembalian</h4>
      <table id="tabel-2" class="no-more-tables table text-dark table-sm table-light w-100 tabel-data" style="word-wrap: break-word;" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>No Rek</th>
            <th>Nama</th>
            <th>CIF</th>
            <th>Lokasi Berkas</th>
            <th>Jenis</th>
            <th>User</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @if ($pengembalian)
          @foreach ($pengembalian as $key => $pe)
          <tr>
            <td data-title="#">{{ $key + 1 }}</td>
            <td data-title="No Rek">{{ $pe->no_rek }}</td>
            <td data-title="Nama">{{ $pe->nama }}</td>
            <td data-title="CIF">{{ $pe->cif }}</td>
            <td data-title="Lokasi">{{ $pe->lokasi }}</td>
            <td data-title="Jenis">{{ $pe->jenis }}</td>
            <td data-title="User">{{ $pe->user }}</td>
            <td data-title="aksi">
              <a onclick="document.getElementById('konfirmasi-pengembalian-{{ $pe->id }}').submit();" class="btn btn-outline" id="aksi-{{$pe->id}}">Konfirmasi</a>
              <a onclick="document.getElementById('tolak-pengembalian-{{ $pe->id }}').submit();" class="btn btn-outline-danger" id="aksi-{{$pe->id}}">Tolak</a>
            </td>
            <form id="konfirmasi-pengembalian-{{ $pe->id }}" action="{{ route('user.konfirmasiPengembalian', $pe->id) }}" method="post" style="display: none;">
              @csrf
            </form>
            <form id="tolak-pengembalian-{{ $pe->id }}" action="{{ route('user.tolakPengembalian', $pe->id) }}" method="post" style="display: none;">
              @csrf
            </form>
          </tr>
          @endforeach
          @endif
          @if ($pengembalian2)
          @foreach ($pengembalian2 as $key => $pg2)
          <tr>
            <td data-title="#">{{ $key + 1 }}</td>
            <td data-title="No Rek">{{ $pg2->no_rek }}</td>
            <td data-title="Nama">{{ $pg2->nama }}</td>
            <td data-title="CIF">{{ $pg2->cif }}</td>
            <td data-title="Lokasi">{{ $pg2->lokasi }}</td>
            <td data-title="Jenis">{{ $pg2->jenis }}</td>
            <td data-title="User">{{ $pg2->user }}</td>
            <td data-title="aksi">
              <a onclick="document.getElementById('konfirmasi-pengembalian-{{ $pg2->id }}').submit();" class="btn btn-outline" id="aksi-{{$pg2->id}}">Konfirmasi</a>
              <a onclick="document.getElementById('tolak-pengembalian-{{ $pg2->id }}').submit();" class="btn btn-outline-danger" id="aksi-{{$pg2->id}}">Tolak</a>
            </td>
            <form id="konfirmasi-pengembalian-{{ $pg2->id }}" action="{{ route('user.konfirmasiPengembalian', $pg2->id) }}" method="post" style="display: none;">
              @csrf
            </form>
            <form id="tolak-pengembalian-{{ $pg2->id }}" action="{{ route('user.tolakPengembalian', $pg2->id) }}" method="post" style="display: none;">
              @csrf
            </form>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
    <hr class="hr border-secondary border-2 opacity-50 mb-5"></hr>
    <h4 id="judul-tabel-1" class="mb-3 fw-medium text-dark">Berkas Aktif</h4>
    <h6 id="judul-tabel-1" class="mb-3 fw-medium text-dark">Ingatkan anggota unit anda untuk mengembalikan berkas</h6>
    <div class="text-white p-4 rounded-3 mb-4 mt-4" style="background-color: #0D3148;">

      <table id="downloadable" class="no-more-tables table text-dark table-sm table-light w-100" style="word-wrap: break-word;" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>No Rek</th>
            <th>Nama</th>
            <th>CIF</th>
            <th>Lokasi Berkas</th>
            <th>Jenis</th>
            <th>User</th>
          </tr>
        </thead>
        <tbody>
          @if($dipinjam)
          @foreach($dipinjam as $key => $de)
          <tr>
            <td data-title="#">{{ $key + 1 }}</td>
            <td data-title="No Rek">{{ $de->no_rek }}</td>
            <td data-title="Nama">{{ $de->nama }}</td>
            <td data-title="CIF">{{ $de->cif }}</td>
            <td data-title="Lokasi Berkas">{{ $de->lokasi }} </td>
            <td data-title="Jenis">{{ $de->jenis }}</td>
            <td data-title="User">{{ $de->user }}</td>
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
    $('#downloadable').DataTable({
      lengthMenu: [
        [3, 5, 10, 25, -1],
        [3, 5, 10, 25, 'All']
      ],
      dom: 'Bfrtip',
      buttons: [{
          extend: 'excel',
          text: 'Excel',
          title: "Berkas sedang dipinjam",
          messageTop: date,
          messageBottom: "Jika berkas sudah tidak digunakan lagi. Mohon kembalikan berkas melalui menu 'Pengembalian'",
          filename: "Berkas sedang dipinjam"
        },
        {
          extend: 'pdf',
          text: 'PDF',
          title: "Berkas sedang dipinjam",
          messageTop: date,
          messageBottom: "Jika berkas sudah tidak digunakan lagi. Mohon mengembalikan berkas melalui menu 'Pengembalian'",
          filename: "Berkas sedang dipinjam"
        },
        {
          extend: 'print',
          text: 'Print',
          title: "Berkas sedang dipinjam",
          messageTop: date,
          messageBottom: "Jika berkas sudah tidak digunakan lagi. Mohon mengembalikan berkas melalui menu 'Pengembalian'",
          filename: "Berkas sedang dipinjam"
        }, 'pageLength',
      ]
    });
  });
</script>
@endsection