<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar">

    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="{{ route('dashboard') }}">

        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book"></i>
        </div>

        <div class="sidebar-brand-text mx-3">
            Library Mini
        </div>

    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">

        <a class="nav-link" href="/dashboard">

            <i class="fas fa-fw fa-home"></i>

            <span>Dashboard</span>

        </a>

    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Master Data
    </div>

    <li class="nav-item">

        <a class="nav-link" href="/books">

            <i class="fas fa-book"></i>

            <span>Data Buku</span>

        </a>

    </li>

    <li class="nav-item">

        <a class="nav-link" href="/loans">

            <i class="fas fa-handshake"></i>

            <span>Peminjaman</span>

        </a>

    </li>

    <li class="nav-item">

        <a class="nav-link" href="/history">

            <i class="fas fa-history"></i>

            <span>Riwayat Saya</span>

        </a>

    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">

        <form action="{{ route('logout') }}"
              method="POST">

            @csrf

            <button type="submit"
                    class="nav-link border-0 bg-transparent text-white">

                <i class="fas fa-sign-out-alt"></i>

                <span>Logout</span>

            </button>

        </form>

    </li>

</ul>