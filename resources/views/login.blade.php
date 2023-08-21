@extends('layout.template')
@section('content')

<section class="vh-100" style="background-color: #f6f6f6;">
    <div class="h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card shadow-lg" style="border-radius: 1rem;">
                    <div class="row g-0 container-fluid" style="border-radius: 1rem 1rem 1rem 1rem; background-color:#217AB3;">
                        <div class="col-md-6" style="border-radius: 1rem 1rem 1rem 1rem; background-color:#0D3148;" >
                            <div class="row g-0 position-relative">
                                <!-- gamber display xl saja -->
                                <div class="col-md-12 d-flex align-items-center justify-content-center d-none d-xl-flex d-xxl-none d-lg-none pt-5">
                                    <img src="images/security.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 0; height: 100%; width: 50%; object-fit: scale-down;" />
                                </div>
                                <!-- gamber display xxl saja -->
                                <div class="col-md-12 d-flex align-items-center justify-content-center d-none d-xxl-flex d-xl-none d-lg-none pt-4">
                                    <img src="images/security.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 0; height: 100%; width: 50%; object-fit: scale-down;" />
                                </div>
                                <!-- gambar display xs dan sm -->
                                <div class="col-md-12 d-flex align-items-center justify-content-center d-lg-none d-xl-none d-md-none pt-4">
                                    <img src="images/security.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 0; height: 100%; width: 50%; object-fit: scale-down;" />
                                </div>
                                <!-- gambar display medium saja -->
                                <div class="col-md-12 d-flex align-items-center justify-content-center d-none d-md-flex d-lg-none pt-5 mt-2">
                                    <img src="images/security.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 0; height: 100%; width: 50%; object-fit: scale-down;" />
                                </div>
                                <!-- gamber display lg saja -->
                                <div class="col-md-12 d-flex align-items-center justify-content-center d-none d-lg-flex d-xl-none d-xxl-none pt-5 mt-3">
                                    <img src="images/security.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 0; height: 100%; width: 50%; object-fit: scale-down;" />
                                </div>
                                
                                <div class="col-md-12 position-absolute top-100 start-0 d-none d-xl-block d-lg-block d-md-block" style="border-radius: 1rem 0 0 0;">
                                    <h1 class="font-weight-bold text-light px-5">BRIMEN</h1>
                                    <h2 class="font-weight-bold px-5 text-light ">Web Integrasi Kearsipan</h2>
                                </div>
                                <div class="col-md-12 h-100 p-3 d-block d-lg-none d-xl-none d-md-none" style="border-radius: 1rem 0 0 0;">
                                    <h1 class="font-weight-bold text-light px-2">BRIMEN</h1>
                                    <h2 class="font-weight-bold text-light px-2">Web Integrasi Kearsipan</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <form action="{{ route('login') }}" method="POST">
                                    @csrf

                                    <h1 class="fw-bold mb-3 pb-3 text-light" style="letter-spacing: 1px;">Masuk</h1>

                                    @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                    @endif

                                    @if(session('berhasil'))
                                    <div class="alert alert-success">
                                        {{ session('berhasil') }}
                                    </div>
                                    @endif
                                    <div class="form-outline mb-4 text-light">
                                        <label class="form-label" for="form2Example17">Email address</label>
                                        <input type="email" name="email" id="form2Example17" class="form-control form-control-lg" required>
                                    </div>

                                    <div class="form-outline mb-4 text-light">
                                        <label class="form-label" for="form2Example27">Password</label>
                                        <input type="password" name="password" id="form2Example27" class="form-control form-control-lg" minlength="8" oninvalid="this.setCustomValidity('Password harus minimal 8 karakter')" oninput="this.setCustomValidity('')" required>
                                    </div>

                                    <div class="button pt-1 mb-4 text-light">
                                        <button class="btn btn-lg btn-block w-100 text-light" type="submit" name="login" value="Login" style="background-color:#2892D7">Masuk</button>
                                    </div>


                                    <p class="mb-5 pb-lg-2 opacity-50">Tidak punya akun? Coba hubungi administrator di kantor unit anda</p>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Bootstrap JS and jQuery scripts here -->

@endsection