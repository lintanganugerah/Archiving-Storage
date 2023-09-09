@extends('layout.cabang.cblayout')
@section('content')
<div class="row">
  <div class="col">
    <div class="text-left mt-3 mb-5">
      <h1 class="fw-medium text-dark">Tambah Unit</h1>
      <h4 class="fw-normal">Buat unit baru disini</h4>
    </div>

    <form action="{{ route('cabang.attemptUnit') }}" method="POST" class="mx-2 mb-5">
      @csrf
      <div class="mb-3">
        <label for="unit" class="form-label fw-bold">Nama Unit</label>
        <input type="text" class="form-control" name="unit" id="unit" required>
      </div>
      <div class="mb-3">
        <label for="kode" class="form-label fw-bold">Kode</label>
        <input type="kode" class="form-control" id="kode" name="kode" required>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<script>
  document.getElementById('kode').addEventListener('input', function() {
    // Hapus huruf yang dimasukkan oleh pengguna
    this.value = this.value.replace(/[^0-9]/g, '');
  });
</script>

@endsection