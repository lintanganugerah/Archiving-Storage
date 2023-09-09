@extends('layout.template')
@include('layout.navbar')
@section('content')
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
            <div class="text-left mt-3 mb-5">
                <h1 class="fw-medium text-dark">Ubah Password</h1>
                <h4 class="fw-normal"></h4>
            </div>
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('user.attemptPassword') }}" method="POST" class="mx-2 mb-5">
                @csrf
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password Aktif</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukan password aktif anda" minlength="8" required>
                    <div id="namaNasabah" class="form-text">Hubungi admin unit jika anda lupa password</div>
                </div>
                <div class="mb-3">
                    <label for="passwordbaru" class="form-label fw-bold">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="passwordbaru" placeholder="Masukan password baru" minlength="8" required>
                </div>
                <div class="mb-3">
                    <label for="konfirmasipassword" class="form-label fw-bold">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password" name="konfirmasipassword" placeholder="Masukan password baru kembali" minlength="8" required>
                </div>

                <button type="submit" class="btn btn-primary">Ubah password</button>
            </form>
        </div>
    </div>
</div>

@endsection