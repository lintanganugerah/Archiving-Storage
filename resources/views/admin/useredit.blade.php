@extends('layout.admin.admlayout')
@section('content')
<div class="row">
    <div class="col">
        <div class="text-left mt-3 mb-5">
            <h1 class="fw-medium text-dark">Edit Pengguna</h1>
            <h4 class="fw-normal"></h4>
        </div>

        <form action="{{ route('user.register') }}" method="POST" class="mx-2 mb-5">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Nama</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label fw-bold">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $user->jabatan }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a type="button" class="btn btn-outline" href="{{ route('user.view') }}">Batalkan</a>

        </form>

        @if ($user->name != session('name'))
        <hr class="mt-4 mb-5 border border-secondary border-2 opacity-50" />
        <div class="text-left mt-3 mb-5">
            <h1 class="fw-medium text-dark">Zona Berbahaya</h1>
            <h4 class="fw-normal text-danger">Hanya lakukan ini atas izin pengguna</h4>
        </div>
        <form action="{{ route('admin.resetPassword', $user->id) }}" method="POST">
            @csrf <!-- Tambahkan token CSRF untuk keamanan -->
            <button type="submit" class="btn btn-outline-danger mb-5" onclick="return confirm('Apakah Anda yakin ingin mereset password?')">
                <i class="fa-solid fa-key"></i> Reset Password
            </button>
        </form>
        @endif
    </div>
</div>

@endsection