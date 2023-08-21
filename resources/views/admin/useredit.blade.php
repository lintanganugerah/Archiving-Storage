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
                <label for="role" class="form-label fw-bold">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
                <div id="namaNasabah" class="form-text">Tanyakan bagian ini kepada admin</div>
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label fw-bold">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $user->jabatan }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password aktif sekarang">
                <div id="namaNasabah" class="form-text">Password digunakan untuk verifikasi bahwa user benar ingin melakukan perubahan</div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-outline">Batalkan</button>

        </form>
    </div>
</div>

@endsection