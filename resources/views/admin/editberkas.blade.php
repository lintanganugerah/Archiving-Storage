@extends('layout.admin.admlayout')
@section('content')
<div class="row">
    <div class="col">
        <div class="text-left mb-5 mt-3">
            <h1 class="fw-medium text-dark">Edit Berkas</h1>
        </div>
        <form action="{{ route('admin.attemptEditBerkas', $berkas->id) }}" method="POST" class="mx-2 mb-5">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label fw-bold">Nama Nasabah</label>
                <input type="text" class="form-control" id="nama" aria-describedby="nama" value="{{$berkas->nama}}" name="nama" required>

            </div>
            <div class="mb-3">
                <label for="rekening" class="form-label fw-bold">No Rekening</label>
                <input type="text" pattern="[0-9]+" class="form-control" id="rekening" name="no_rek" title="Hanya angka yang diperbolehkan" value="{{$berkas->no_rek}}" maxlength="15" required>
            </div>
            <div class="mb-3">
                <label for="cif" class="form-label fw-bold">CIF</label>
                <input type="text" class="form-control" id="cif" name="cif" value="{{$berkas->cif}}" maxlength="7" required>
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label fw-bold">Jenis</label>
                <select class="form-select" id="jenisSelect" aria-label="Default select example" name="jenis" onchange="kreditChange(this);">
                    <option value="Tabungan" {{ $berkas->jenis == 'Tabungan' ? 'selected' : '' }}>Tabungan</option>
                    <option value="Lunas" {{ $berkas->jenis == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Kredit" {{ $berkas->jenis == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                    <option value="Daftar Hitam" {{ $berkas->jenis == 'Daftar Hitam' ? 'selected' : '' }}>Daftar Hitam</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="ruang" class="form-label fw-bold">Ruang</label>
                <input type="text" class="form-control" id="ruang" name="ruang" value="{{$berkas->ruang}}" required>
            </div>
            <div class="mb-3">
                <label for="lemari" class="form-label fw-bold">Lemari</label>
                <input type="text" class="form-control" id="lemari" name="lemari" value="{{$berkas->lemari}}" required>
            </div>
            <div class="mb-3">
                <label for="rak" class="form-label fw-bold">Rak</label>
                <input type="text" class="form-control" id="rak" name="rak" value="{{$berkas->rak}}" required>
            </div>
            <div class="mb-3">
                <label for="baris" class="form-label fw-bold">Baris</label>
                <input type="text" class="form-control" id="baris" name="baris" value="{{$berkas->baris}}" required>
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
                <div id="namaNasabah" class="form-text">Bagian ini tidak dapat diubah secara langsung. Tekan tombol edit dibawah untuk melakukan perubahan</div>
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

            <button type="submit" class="btn btn-primary">Submit</button>
            <a id="editButton" class="btn btn-outline">Edit Agunan</a>
        </form>
    </div>
</div>
<script>
    document.getElementById('rekening').addEventListener('input', function() {
        // Hapus huruf yang dimasukkan oleh pengguna
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    document.getElementById('rak').addEventListener('input', function() {
        // Hapus huruf yang dimasukkan oleh pengguna
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    document.getElementById('ruang').addEventListener('input', function() {
        // Hapus huruf yang dimasukkan oleh pengguna
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    document.getElementById('baris').addEventListener('input', function() {
        // Hapus huruf yang dimasukkan oleh pengguna
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    var isEditable = false;
    var agunan = document.getElementById('agunan');
    var ruangAgunanInput = document.getElementById('ruangAgunan');
    var lemariAgunanInput = document.getElementById('lemariAgunan');
    var rakAgunanInput = document.getElementById('rakAgunan');
    var barisAgunanInput = document.getElementById('barisAgunan');
    var originalAgunanValue = agunan.value;
    var originalRuangValue = ruangAgunanInput.value;
    var originalLemariValue = lemariAgunanInput.value;
    var originalRakValue = rakAgunanInput.value;
    var originalBarisValue = barisAgunanInput.value;

    document.getElementById('editButton').addEventListener('click', function() {


        if (isEditable) {
            // Simpan perubahan jika tombol "Simpan" ditekan

            agunan.setAttribute('disabled', true);
            ruangAgunanInput.setAttribute('disabled', true);
            lemariAgunanInput.setAttribute('disabled', true);
            rakAgunanInput.setAttribute('disabled', true);
            barisAgunanInput.setAttribute('disabled', true);

            // Hapus isi dari inputan
            agunan.value = originalAgunanValue;
            ruangAgunanInput.value = originalRuangValue;
            lemariAgunanInput.value = originalLemariValue;
            rakAgunanInput.value = originalRakValue;
            barisAgunanInput.value = originalBarisValue;

            this.textContent = 'Edit';
            isEditable = false;
        } else {
            // Ubah ke mode edit jika tombol "Edit" ditekan

            agunan.removeAttribute('disabled');
            ruangAgunanInput.removeAttribute('disabled');
            lemariAgunanInput.removeAttribute('disabled');
            rakAgunanInput.removeAttribute('disabled');
            barisAgunanInput.removeAttribute('disabled');

            agunan.required = true;
            ruangAgunanInput.required = true;
            lemariAgunanInput.required = true;
            rakAgunanInput.required = true;
            barisAgunanInput.required = true;

            this.textContent = 'Batalkan Edit';
            isEditable = true;
        }

    });

    const jenisSelect = document.getElementById('jenisSelect');

    // Add an event listener to the select element
    jenisSelect.addEventListener('change', function() {
        const selectedValue = jenisSelect.value;

        // Get the required input elements below the select element
        const ruangAgunanInput = document.getElementById('ruangAgunan');
        const lemariAgunanInput = document.getElementById('lemariAgunan');
        const rakAgunanInput = document.getElementById('rakAgunan');
        const barisAgunanInput = document.getElementById('barisAgunan');

        // Set the "required" attribute based on the selected value
        if (selectedValue === 'Kredit') { // "Kredit" option
            agunan.required = true;
            ruangAgunanInput.required = true;
            lemariAgunanInput.required = true;
            rakAgunanInput.required = true;
            barisAgunanInput.required = true;
        } else {
            agunan.required = false;
            ruangAgunanInput.required = false;
            lemariAgunanInput.required = false;
            rakAgunanInput.required = false;
            barisAgunanInput.required = false;
        }
    });
</script>
@endsection