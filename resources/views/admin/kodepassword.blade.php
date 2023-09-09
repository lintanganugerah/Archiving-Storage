@extends('layout.admin.admlayout')
@section('content')
<div class="row">
    <div class="col">
        @if(isset($passbaru))
        <div class="text-left mt-3 mb-5">
            <h1 class="fw-medium text-dark">{{ $passbaru }}</h1>
            <p class="fw-medium text-dark">Berikan password baru ini kepada user untuk melakukan login</p>
            <p><b> Berikan arahan untuk mengganti password setelah login</b></p>
            <a type="button" class="btn btn-primary" href="{{ route('user.view') }}">Kembali</a>
        </div>
        @else
        @endif
    </div>
</div>

@endsection