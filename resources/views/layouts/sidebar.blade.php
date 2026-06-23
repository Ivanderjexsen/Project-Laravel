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

    <!-- Dashboard (Semua User) -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- ========================================== -->
    <!-- MENU UNTUK ADMIN                           -->
    <!-- ========================================== -->
    @auth
    @if(Auth::user()->role === 'admin')
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

    <!-- Data Peminjaman (Admin) -->
    <li class="nav-item {{ request()->routeIs('admin.loans.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.loans.index') }}">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Data Peminjaman</span>
        </a>
    </li>

    <!-- Data User -->
    <li class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data User</span>
        </a>
    </li>
    @endif
    @endauth

    <!-- ========================================== -->
    <!-- MENU UNTUK USER                            -->
    <!-- ========================================== -->
    @auth
    @if(Auth::user()->role === 'user')
    <div class="sidebar-heading">
        MENU USER
    </div>


    <li class="nav-item {{ request()->routeIs('user.buku.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.buku.index') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Data Buku</span>
        </a>
    </li>

    <!-- Histori Peminjaman Saya (User) -->
    <li class="nav-item {{ request()->routeIs('user.loans.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.loans.index') }}">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Data Peminjaman</span>
        </a>
    </li>
    @endif
    @endauth

    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </li>

</ul>