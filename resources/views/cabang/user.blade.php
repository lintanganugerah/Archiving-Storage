@extends('layout.cabang.cblayout')
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
            ...
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
    <a href="{{ route('cabang.user.create') }}" class="btn btn-outline-primary" id="aksi-#"><i class="fa-solid fa-user-plus"></i> Tambah Pengguna Baru</a>
    <div class="text-white p-4 rounded-3 mb-4 mt-4" style="background-color: #0D3148;">
      <table id="tabel" class="no-more-tables table text-dark table-sm table-light w-100 tabel-data" style="word-wrap: break-word;" cellspacing="0">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email Address</th>
            <th>Jabatan</th>
            <th>Roles</th>
            <th>Unit</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
          <tr>
            <td data-title="Nama">{{ $user->name }}</td>
            <td data-title="Email ">{{ $user->email }}</td>
            <td data-title="Jabatan">{{ $user->jabatan }}</td>
            <td data-title="Role">{{ $user->role }}</td>
            <td data-title="Unit">{{ $user->unit }}</td>
            <td data-title="aksi">
              <a href="#" class="btn btn-outline-danger" onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus user ini?')) { document.getElementById('delete-form-{{ $user->id }}').submit(); }">
                <i class="fa-solid fa-trash-can"></i>
              </a>

              <form id="delete-form-{{ $user->id }}" action="{{ route('cabang.user.destroy', $user->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
              </form>
              <a href="{{ route('cabang.user.editView', $user->id) }}" class="btn btn-outline" style="margin-right: -10vw;">
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
        [5, 10, 15, 25, -1],
        [5, 10, 15, 25, 'All']
      ],
      dom: 'Bfrtip',
      fixedHeader: true,
      rowGroup: {
        dataSrc: 4
      }
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