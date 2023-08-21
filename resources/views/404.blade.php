@extends('layout.template')
@section('content')

<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
        <h1 class="display-1 fw-bold">404 NOT FOUND</h1>
        <p class="fs-3"> <span class="text-danger">{{ $error }}</span></p>
        <p class="lead">
            <a href="/" class="text-reset">{{ $msg }}</a>
        </p>
    </div>
</div>

@endsection