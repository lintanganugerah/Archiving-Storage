@extends('layout.template')
@include('layout.navbar')
@section('content')
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
            <div class="text-left mt-3 mb-5">
                <h1 class="fw-medium text-dark">Profile anda</h1>
                <h4 class="fw-normal"></h4>
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
            <form action="{{ route('user.ubahProfile') }}" method="POST" class="mx-2 mb-5">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password aktif sekarang" required>
                    <div id="namaNasabah" class="form-text">Password digunakan untuk verifikasi bahwa user benar ingin melakukan perubahan. <a href="{{ route('user.resetPassword') }}" class="text-danger">Klik disini jika anda ingin ubah password</a> </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

@endsection