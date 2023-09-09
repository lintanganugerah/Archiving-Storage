@extends('layout.cabang.cblayout')
@section('content')

<div class="row">
  <div class="col">
    <div class="text-left mb-5 mt-3">
      <h1 class="fw-medium text-dark">Beranda</h1>
      <h5 class="text-dark">Anda login sebagai <a href="{{ route('cabang.viewProfile') }}" class="text-reset"><u>{{ session('name') }}!</u></a></h5>
    </div>

    <div class="row gx-5">
      <!-- Earnings (Monthly) Card Example -->
      <div class="col mb-4">
        <div class="card shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                  Total Berkas</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['allberkas'] }}</div>
              </div>
              <div class="col-auto test" id="icon-beranda-1">
                <i class="fas fa-file-circle-check fa-2x text-gray-400"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col mb-4">
        <div class="card shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                  Berkas Dipinjam</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['dipinjam'] }}</div>
              </div>
              <div class="col-auto" id="icon-beranda-2">
                <i class="fas fa-file-export fa-2x text-gray-400"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row gx-5">
      <!-- Earnings (Monthly) Card Example -->
      <div class="col mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Berkas Tabungan
                </div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $data['tabungan'] }}</div>
                  </div>
                </div>
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
                  Berkas Kredit</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['kredit'] }}</div>
              </div>
              <div class="col-auto" id="icon-beranda-4">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                  Berkas Lunas</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['lunas'] }}</div>
              </div>
              <div class="col-auto" id="icon-beranda-4">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                  Berkas Daftar Hitam</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['daftarhitam'] }}</div>
              </div>
              <div class="col-auto" id="icon-beranda-4">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row gx-5 mt-5">

      <div class="text-left m-3">
        <h1 class="fw-medium text-dark">Berkas baru hari ini</h1>
        <h5 class="text-dark">{{ $tanggal }}</u></a></h5>
      </div>

      <div class="col m-3">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title">Berkas tabungan baru</h5>
            <h1 class="display-2">+{{ $tabungan }}</h1>
          </div>
          <div class="card-footer">
            <span class="badge bg-secondary">Hari Ini</span>
          </div>
        </div>
      </div>
      <div class="col m-3">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title">Berkas kredit baru</h5>
            <h1 class="display-2">+{{ $kredit }}</h1>
          </div>
          <div class="card-footer">
            <span class="badge bg-secondary">Hari Ini</span>
          </div>
        </div>
      </div>
      <div class="col m-3">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title">Berkas lunas baru</h5>
            <h1 class="display-2">+{{ $lunas }}</h1>
          </div>
          <div class="card-footer">
            <span class="badge bg-secondary">Hari Ini</span>
          </div>
        </div>
      </div>
      <div class="col m-3">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title">Berkas daftar hitam baru</h5>
            <h1 class="display-2">+{{ $daftarhitam }}</h1>
          </div>
          <div class="card-footer">
            <span class="badge bg-secondary">Hari Ini</span>
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
  @endsection