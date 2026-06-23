<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon mb-3">
            <i class="fas fa-book"></i>
        </div>
        <div class="brand-title">
            LIBRARY MINI
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        MASTER DATA
    </div>

    <!-- Data Buku -->
    <li class="nav-item {{ request()->routeIs('buku.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('buku.index') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Data Buku</span>
        </a>
    </li>

    <!-- Peminjaman -->
    <li class="nav-item {{ request()->routeIs('loans.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('loans.index') }}">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Data Peminjaman</span>
        </a>
    </li>

    <!-- Riwayat Saya -->
    <li class="nav-item {{ request()->routeIs('history.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('history.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data User</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link border-0 bg-transparent text-white w-100 text-start">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
</ul>