<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon mb-3">
            <i class="fas fa-book"></i>
        </div>
        <div class="brand-title">
            LIBRARY MINI
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @auth
        @if(Auth::user()->role === 'admin')
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                MASTER DATA
            </div>

            <li class="nav-item {{ request()->routeIs('buku.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('buku.index') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('loans.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('loans.index') }}">
                    <i class="fas fa-fw fa-handshake"></i>
                    <span>Data Peminjaman</span>
                </a>
            </li>
        @endif
    @endauth

   
    @auth
        
    @endauth

  

</ul>