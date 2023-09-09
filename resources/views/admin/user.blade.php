@extends('layout.admin.admlayout')
@section('content')

<div class="row">
  <div class="col">
    <div class="text-left mb-5 mt-3">
      <h1 class="fw-medium text-dark">User <a class="btn" data-bs-toggle="modal" data-bs-target="#helpModal"><i class="fa-solid fa-circle-question fa-lg" style="color: #0D3148;"></i></a></h1>
      <h4 class="fw-normal">Manajemen pengguna website disini</h4>
    </div>
    <!-- Modal Help Judul -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Pada halaman ini anda melakukan manajemen user. Setiap hal yang anda lakukan akan tercatat pada log aktivitas.
            Baca selengkapnya dibawah
            <p id="judul-tabel-1" class="mb-3 mt-2 fw-bold">Tata Cara</p>
            <ol class="list-group">
              <li class="list-group-item">
                <div class="fw-bold">Saya ingin menambah pengguna baru</div>
                Tekan tombol "Tambah Pengguna baru" lalu isi detail pengguna
              </li>
              <li class="list-group-item">
                <div class="fw-bold">Staff unit ingin melakukan reset password, bagaimana caranya?</div>
                Cari nama akun staff tujuan lalu tekan tombol pulpen pada kolom aksi, scroll kebawah dan tekan "Reset password"
              </li>
              <li class="list-group-item">
                <div class="fw-bold">Saya ingin menghapus pengguna</div>
                Tekan tombol dengan logo bak sampah pada kolom aksi
              </li>
              <li class="list-group-item">
                <div class="fw-bold">Saya ingin melakukan perubahan pengguna</div>
                Tekan tombol puplen pada kolom aksi
              </li>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
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
    <a href="{{ route('user.create') }}" class="btn btn-outline-primary" id="aksi-#"><i class="fa-solid fa-user-plus"></i> Tambah Pengguna Baru</a>
    <div class="text-white p-4 rounded-3 mb-4 mt-4" style="background-color: #0D3148;">
      <table id="tabel" class="no-more-tables table text-dark table-sm table-light w-100 tabel-data" style="word-wrap: break-word;" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email Address</th>
            <th>Jabatan</th>
            <th>Roles</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $key => $user)
          <tr>
            <td data-title="#">{{ $key+1 }}</td>
            <td data-title="Nama">{{ $user->name }}</td>
            <td data-title="Email ">{{ $user->email }}</td>
            <td data-title="Jabatan">{{ $user->jabatan }}</td>
            <td data-title="Role">{{ $user->role }}</td>
            <td data-title="aksi">
              <a href="#" class="btn btn-outline-danger" onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus user ini?')) { document.getElementById('delete-form-{{ $user->id }}').submit(); }">
                <i class="fa-solid fa-trash-can"></i>
              </a>

              <form id="delete-form-{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
              </form>
              <a href="{{ route('user.editView', $user->id) }}" class="btn btn-outline" style="margin-right: -10vw;">
                <i class="fa-solid fa-pen-to-square"></i>
              </a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="toast" id="success-toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
        <div class="toast-header">
          <strong class="mr-auto">Success</strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          Berhasil Melakukan perubahan
        </div>
      </div>
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

  });

  function updateFormAndSubmit(selectElement) {
    var selectedValue = selectElement.value;
    var formId = selectElement.getAttribute('data-user-id');

    var hiddenInput = document.querySelector('#update-form-' + formId + ' #selected-role');
    hiddenInput.value = selectedValue;

    document.getElementById('update-form-' + formId).submit();
  }
</script>
@endsection