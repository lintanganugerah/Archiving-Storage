@extends('layout.admin.admlayout')
@section('content')
<div class="row">
    <div class="col">
        <div class="text-left mb-5 mt-3">
            <h1 class="fw-medium text-dark">Detail Berkas</h1>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Terakhir diubah :</label>
            @if($update)
            <p>{{ $update->created_at }} oleh {{ $update->role }} {{ $update->user }} </p>
            <p>{{ $update->aktivitas }}
            @else
            <p>-</p>
            @endif
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Nama Nasabah</label>
            <input type="text" class="form-control" id="nama" aria-describedby="nama" value="{{$berkas->nama}}"disabled>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Lokasi Berkas</label>
            <input type="text" class="form-control" id="nama" aria-describedby="nama" value="{{$berkas->lokasi}}"disabled>
        </div>
        <div class="mb-3">
            <label for="rekening" class="form-label fw-bold">No Rekening</label>
            <input type="text" pattern="[0-9]+" class="form-control" id="rekening" name="no_rek" title="Hanya angka yang diperbolehkan" value="{{$berkas->no_rek}}" maxlength="15" disabled>
        </div>
        <div class="mb-3">
            <label for="cif" class="form-label fw-bold">CIF</label>
            <input type="text" class="form-control" id="cif" name="cif" value="{{$berkas->cif}}" maxlength="7" disabled>
        </div>
        <div class="mb-3">
            <label for="jenis" class="form-label fw-bold">jenis</label>
            <input type="text" class="form-control" id="jenis" name="jenis" value="{{$berkas->jenis}}" maxlength="7" disabled>
        </div>
        <div class="mb-3">
            <label for="ruang" class="form-label fw-bold">Ruang</label>
            <input type="text" class="form-control" id="ruang" name="ruang" value="{{$berkas->ruang}}" disabled>
        </div>
        <div class="mb-3">
            <label for="lemari" class="form-label fw-bold">Lemari</label>
            <input type="text" class="form-control" id="lemari" name="lemari" value="{{$berkas->lemari}}" disabled>
        </div>
        <div class="mb-3">
            <label for="rak" class="form-label fw-bold">Rak</label>
            <input type="text" class="form-control" id="rak" name="rak" value="{{$berkas->rak}}" disabled>
        </div>
        <div class="mb-3">
            <label for="baris" class="form-label fw-bold">Baris</label>
            <input type="text" class="form-control" id="baris" name="baris" value="{{$berkas->baris}}" disabled>
        </div>
        @if ($agunan)
        <hr class="mt-4 mb-4 border border-secondary border-2 opacity-50" />
        <div class="mb-3">
            <label for="agunan" class="form-label fw-bold">Agunan</label>
            <input type="text" class="form-control" id="agunan" name="agunan" value="{{$agunan->agunan}}" disabled>
        </div>
        <div class="mb-3">
            <label for="lokasiAgunan" class="form-label fw-bold">Lokasi Agunan</label>
            <div class="form-text">Ruang Agunan</div>
            <input type="text" class="form-control" id="ruangAgunan" name="ruang_agunan" value="{{$agunan->ruang_agunan}}" disabled>
            <div class="form-text">Lemari Agunan</div>
            <input type="text" class="form-control" id="lemariAgunan" name="lemari_agunan" value="{{$agunan->lemari_agunan}}" disabled>
            <div class="form-text">Rak Agunan</div>
            <input type="text" class="form-control" id="rakAgunan" name="rak_agunan" value="{{$agunan->rak_agunan}}" disabled>
            <div class="form-text">Baris Agunan</div>
            <input type="text" class="form-control" id="barisAgunan" name="baris_agunan" value="{{$agunan->baris_agunan}}" disabled>
        </div>
        @else
        <hr class="mt-4 mb-4 border border-secondary border-2 opacity-50" />
        <div class="mb-3">
            <label for="agunan" class="form-label fw-bold">Agunan</label>
            <input type="text" class="form-control" id="agunan" name="agunan" disabled>
        </div>
        <div class="mb-3">
            <label for="lokasiAgunan" class="form-label fw-bold">Lokasi Agunan</label>
            <div class="form-text">Ruang Agunan</div>
            <input type="text" class="form-control" id="ruangAgunan" name="ruang_agunan" disabled>
            <div class="form-text">Lemari Agunan</div>
            <input type="text" class="form-control" id="lemariAgunan" name="lemari_agunan" disabled>
            <div class="form-text">Rak Agunan</div>
            <input type="text" class="form-control" id="rakAgunan" name="rak_agunan" disabled>
            <div class="form-text">Baris Agunan</div>
            <input type="text" class="form-control" id="barisAgunan" name="baris_agunan" disabled>
        </div>
        @endif
    </div>
</div>
@endsection