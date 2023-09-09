<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #0D3148;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> -->
        <div class="sidebar-brand-icon mx-3">BRIMEN ADMIN CABANG</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/cabang/beranda">
            <i class="fa-solid fa-house"></i>
            <span>Beranda</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu lain
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="/cabang/user">
            <i class="fa-solid fa-user"></i>
            <span>User</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="/cabang/databerkas">
            <i class="fa-solid fa-database"></i>
            <span>Data Berkas</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/cabang/unit">
            <i class="fa-solid fa-building-columns"></i>
            <span>Unit</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/cabang/log">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>Log Aktivitas</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
            @csrf
            <a class="nav-link" href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </form>
    </li>


    <!-- Sidebar Message -->
    <!-- <div class="sidebar-card d-none d-lg-flex">
        <a class="btn btn-outline-sidebar btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Logout</a>
    </div> -->

</ul>
<!-- End of Sidebar -->

<script>
    function toggleSidebarVisibility() {
        const sidebar = document.getElementById('accordionSidebar');
        const topbar = document.getElementById('topbar');
        const sidebarToggleBtn = document.querySelector('#sidebar-toggle-btn');
        const iconBeranda = document.querySelector('#icon-beranda-1');

        // Cek apakah elemen sidebar saat ini memiliki class "hidden" (sedang tersembunyi)
        const isSidebarHidden = sidebar.classList.contains('hidden');

        // Jika saat ini tersembunyi, hapus class "hidden" dan ubah teks tombol menjadi "Sembunyikan Sidebar"
        // Jika saat ini ditampilkan, tambahkan class "hidden" dan ubah teks tombol menjadi "Tampilkan Sidebar"
        if (isSidebarHidden) {
            sidebar.classList.remove('hidden');
            sidebarToggleBtn.textContent = 'Sembunyikan Sidebar';
        } else {
            sidebar.classList.add('hidden');
            sidebarToggleBtn.textContent = 'Tampilkan Sidebar';
        }
    }

    // Ambil halaman saat ini (misalnya, jika URL adalah https://contoh.com/admin/dashboard, halaman saat ini adalah "/admin/dashboard")
    const currentPage = window.location.pathname;

    // Cari elemen dengan class "nav-link" yang memiliki atribut "href" sesuai dengan halaman saat ini
    const activeLink = document.querySelector(`.nav-link[href="${currentPage}"]`);

    // Jika elemen ditemukan, tambahkan atau hapus class "active" pada elemen parent <li> menggunakan toggle
    activeLink?.closest('.nav-item')?.classList.toggle("active");

    // Tambahkan fungsi untuk menampilkan kembali sidebar saat lebar layar di bawah 768px
    function showSidebarIfBelow768px() {
        const sidebar = document.getElementById('accordionSidebar');
        const sidebarToggleBtn = document.querySelector('#sidebar-toggle-btn');
        const iconBerandaIds = ['icon-beranda-1', 'icon-beranda-2', 'icon-beranda-3', 'icon-beranda-4'];

        // Cek apakah layar berada di bawah 768px
        if (window.innerWidth >= 768) {
            // Jika di atas 768px, hapus class "hidden" dari elemen sidebar
            sidebar.classList.remove('hidden');
            topbar.classList.add('hidden');
        } else {
            // Jika dibawah 768px, tambahkan class "hidden" pada elemen sidebar
            sidebar.classList.add('hidden');
            topbar.classList.remove('hidden');
        }
    }

    function hapusIcon() {
        const iconBerandaIds = ['icon-beranda-1', 'icon-beranda-2', 'icon-beranda-3', 'icon-beranda-4'];

        // Cek apakah layar berada di bawah 1024px
        if (window.innerWidth > 1024) {
            iconBerandaIds.forEach((id) => {
                const iconBeranda = document.querySelector(`#${id}`);
                iconBeranda.classList.remove('hidden');
            });
        } else {
            iconBerandaIds.forEach((id) => {
                const iconBeranda = document.querySelector(`#${id}`);
                iconBeranda.classList.add('hidden');
            });
        }
    }

    // Panggil fungsi showSidebarIfBelow768px() saat halaman dimuat dan saat ukuran layar berubah
    window.addEventListener('load', showSidebarIfBelow768px);
    window.addEventListener('resize', showSidebarIfBelow768px);
    window.addEventListener('load', hapusIcon);
    window.addEventListener('resize', hapusIcon);
</script>