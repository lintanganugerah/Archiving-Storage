<nav class="navbar navbar-expand-md navbar-dark fixed-top" aria-label="Eighth navbar example" style="background-color: #0D3148;">
    <div class="container">
        <a class="navbar-brand fw-bold" style="color: #CED0D9" href="#">BRIMEN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-controls="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="color: #CED0D9">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('user.viewHome') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.viewPeminjaman') }}">Peminjaman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pengembalian">Pengembalian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/riwayat">Riwayat</a>
                </li>
            </ul>
            <div id="kanan" class="navbar-nav d-flex align-items-center">
                <div id="unit" class="text-white mx-3">Unit {{ session('unit') }}</div>
                <a id="button-logout" class="btn btn-outline-light" style="border-color: #D4E9F7;" onclick="document.getElementById('logoutForm').submit();">Logout</a>
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    // Ambil halaman saat ini (misalnya, jika URL adalah https://contoh.com/home, halaman saat ini adalah "/home")
    var currentPage = window.location.pathname;

    // Ambil semua elemen dengan class "nav-link"
    const activeLink = document.querySelector(`.nav-link[href="${currentPage}"]`);

    // Jika elemen ditemukan, tambahkan class "active" ke elemen tersebut
    if (activeLink) {
        activeLink.classList.add("active");
    }
</script>