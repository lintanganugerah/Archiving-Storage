@extends('layout.admin.admlayout')
@section('content')
<div class="row">
    <div class="col">
        <div class="text-left mb-5 mt-3">
            <h1 class="fw-medium text-dark">Buat Berkas Baru</h1>
        </div>
        <form action="{{ route('admin.storeBerkas') }}" method="POST" class="mx-2 mb-5">
            @csrf
            <div class="mb-3">
                <label for="namaNasabah" class="form-label fw-bold">Nama Nasabah</label>
                <input type="text" class="form-control" id="namaNasabah" aria-describedby="namaNasabah" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="rekening" class="form-label fw-bold">No Rekening</label>
                <input type="text" pattern="[0-9]*" class="form-control" id="rekening" name="no_rek" title="Hanya angka yang diperbolehkan" minlength="11" maxlength="14" required>
            </div>
            <div class="mb-3">
                <label for="cif" class="form-label fw-bold">CIF</label>
                <input type="text" class="form-control" id="cif" name="cif" minlength="5" maxlength="7" required>
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label fw-bold">Jenis</label>
                <select class="form-select" aria-label="Default select example" id="jenisSelect" name="jenis">
                    <option value="Tabungan">Tabungan</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Kredit">Kredit</option>
                    <option value="Daftar Hitam">Daftar Hitam</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="ruang" class="form-label fw-bold">Ruang</label>
                <input type="text" class="form-control" id="ruang" name="ruang" required>
            </div>
            <div class="mb-3">
                <label for="lemari" class="form-label fw-bold">Lemari</label>
                <input type="text" class="form-control" id="lemari" name="lemari" maxlength="2" required>
            </div>
            <div class="mb-3">
                <label for="rak" class="form-label fw-bold">Rak</label>
                <input type="text" class="form-control" id="rak" name="rak" required>
            </div>
            <div class="mb-3">
                <label for="baris" class="form-label fw-bold">Baris</label>
                <input type="text" class="form-control" id="baris" name="baris" required>
            </div>
            <hr class="mt-4 mb-4 border border-secondary border-2 opacity-50" />
            <div class="mb-3">
                <label for="agunan" class="form-label fw-bold">Agunan</label>
                <input type="text" class="form-control" id="agunan" name="agunan" disabled>
            </div>
            <div class="mb-3">
                <label for="lokasiAgunan" class="form-label fw-bold">Lokasi Agunan</label>
                <div id="namaNasabah" class="form-text mb-4">Hanya di isi jika jenis berkas Kredit</div>
                <div class="form-text">Ruang Agunan</div>
                <input type="text" class="form-control" id="ruangAgunan" name="ruang_agunan" disabled>
                <div class="form-text">Lemari Agunan</div>
                <input type="text" class="form-control" id="lemariAgunan" name="lemari_agunan" maxlength="2" disabled>
                <div class="form-text">Rak Agunan</div>
                <input type="text" class="form-control" id="rakAgunan" name="rak_agunan" disabled>
                <div class="form-text">Baris Agunan</div>
                <input type="text" class="form-control" id="barisAgunan" name="baris_agunan" disabled>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
</div>

<script>
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
            agunan.disabled = false;
            ruangAgunanInput.disabled = false;
            lemariAgunanInput.disabled = false;
            rakAgunanInput.disabled = false;
            barisAgunanInput.disabled = false;
        } else {
            agunan.required = false;
            ruangAgunanInput.required = false;
            lemariAgunanInput.required = false;
            rakAgunanInput.required = false;
            barisAgunanInput.required = false;
            agunan.disabled = true;
            ruangAgunanInput.disabled = true;
            lemariAgunanInput.disabled = true;
            rakAgunanInput.disabled = true;
            barisAgunanInput.disabled = true;
        }
    });

    // Menggunakan event listener untuk memvalidasi input saat pengguna mengetik
    document.getElementById('rekening').addEventListener('input', function(e) {
        // Menghilangkan karakter selain angka dari nilai input
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('ruang').addEventListener('input', function(e) {
        // Menghilangkan karakter selain angka dari nilai input
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    document.getElementById('lemari').addEventListener('input', function(e) {
        // Menghilangkan karakter selain angka dari nilai input
        this.value = this.value.replace(/[^A-Za-z]/g, '');
    });

    document.getElementById('rak').addEventListener('input', function(e) {
        // Menghilangkan karakter selain angka dari nilai input
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('baris').addEventListener('input', function(e) {
        // Menghilangkan karakter selain angka dari nilai input
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('ruangAgunan').addEventListener('input', function(e) {
        // Menghilangkan karakter selain angka dari nilai input
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('lemariAgunan').addEventListener('input', function(e) {
        // Menghilangkan karakter selain angka dari nilai input
        this.value = this.value.replace(/[^A-Za-z]/g, '');
    });

    document.getElementById('rakAgunan').addEventListener('input', function(e) {
        // Menghilangkan karakter selain angka dari nilai input
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.getElementById('barisAgunan').addEventListener('input', function(e) {
        // Menghilangkan karakter selain angka dari nilai input
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    
</script>
@endsection