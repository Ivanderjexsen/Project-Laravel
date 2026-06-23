<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Left Side: Brand -->
    <h4 class="text-primary mb-0">
        <i class="fas fa-book-open mr-2"></i> LIBRARY MINI
    </h4>

    <!-- Right Side: User Dropdown -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            @auth
                <!-- Tombol dropdown -->
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   onclick="toggleDropdown(event)"
                   style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #333; cursor: pointer; padding: 8px 12px; border-radius: 8px; transition: background 0.3s ease;">
                    <span>
                        <i class="fas fa-user-circle fa-lg"></i>
                        {{ Auth::user()->name }}
                    </span>
                    @if(Auth::user()->role === 'admin')
                        <span class="badge badge-admin">Admin</span>
                    @endif
                    <i class="fas fa-chevron-down" id="dropdownArrow" style="font-size: 10px; color: #858796; transition: transform 0.3s ease;"></i>
                </a>

                <!-- Dropdown Menu dengan Animasi -->
                <div class="dropdown-menu dropdown-menu-right shadow" id="dropdownMenu"
                     style="display: none; position: absolute; right: 0; top: 100%; min-width: 220px; background: white; border-radius: 12px; padding: 10px 0; box-shadow: 0 20px 60px rgba(0,0,0,0.2); z-index: 1000;">

                    <!-- Header: Nama & Email -->
                    <div class="dropdown-item text-center" style="padding: 12px 20px; border-bottom: 1px solid #f0f0f0;">
                        <strong style="font-size: 16px; color: #2d3748;">{{ Auth::user()->name }}</strong>
                        <br>
                        <small style="color: #718096; font-size: 13px;">{{ Auth::user()->email }}</small>
                        @if(Auth::user()->role === 'admin')
                            <br>
                            <span class="badge badge-admin" style="margin-top: 6px; display: inline-block;">Administrator</span>
                        @endif
                    </div>

                    

                    <div style="border-top: 1px solid #f0f0f0; margin: 5px 10px;"></div>

                    <!-- Menu: Logout -->
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       style="padding: 10px 20px; color: #e53e3e; text-decoration: none; display: flex; align-items: center; gap: 12px; transition: all 0.2s ease;">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw" style="color: #e53e3e; width: 20px;"></i>
                        <span style="color: #e53e3e;">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            @endauth
        </li>
    </ul>

</nav>

<!-- ========================================== -->
<!-- CSS ANIMASI DROPDOWN                        -->
<!-- ========================================== -->
<style>
    /* ===== BADGE ADMIN ===== */
    .badge-admin {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ===== DROPDOWN ANIMASI ===== */
    #dropdownMenu {
        display: none;
        opacity: 0;
        transform: translateY(-15px) scale(0.95);
        transform-origin: top right;
        transition: none;
    }

    #dropdownMenu.show {
        display: block !important;
        animation: dropdownSlideIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    #dropdownMenu.hide {
        display: block !important;
        animation: dropdownSlideOut 0.25s ease-in forwards;
    }

    @keyframes dropdownSlideIn {
        0% {
            opacity: 0;
            transform: translateY(-15px) scale(0.95);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes dropdownSlideOut {
        0% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        100% {
            opacity: 0;
            transform: translateY(-15px) scale(0.95);
        }
    }

    /* ===== DROPDOWN ITEM HOVER ===== */
    .dropdown-item {
        transition: all 0.2s ease;
        border-radius: 0;
    }

    .dropdown-item:hover {
        background: linear-gradient(90deg, #f7fafc, #edf2f7);
        padding-left: 26px !important;
    }

    /* Hover khusus untuk logout */
    .dropdown-item:last-child:hover {
        background: linear-gradient(90deg, #fff5f5, #fed7d7);
    }

    /* ===== ANIMASI PANAH ===== */
    #dropdownArrow.rotated {
        transform: rotate(180deg);
    }

    /* ===== TOMBOL DROPDOWN HOVER ===== */
    .dropdown-toggle:hover {
        background: #f7fafc;
    }

    /* ===== SHADOW DROPDOWN ===== */
    #dropdownMenu {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        #dropdownMenu {
            min-width: 180px;
            right: -10px;
        }
    }
</style>

<!-- ========================================== -->
<!-- JAVASCRIPT MANUAL DROPDOWN                 -->
<!-- ========================================== -->
<script>
    let isDropdownOpen = false;

    function toggleDropdown(event) {
        event.preventDefault();
        event.stopPropagation();

        var menu = document.getElementById('dropdownMenu');
        var arrow = document.getElementById('dropdownArrow');

        if (isDropdownOpen) {
            // Tutup dropdown
            menu.classList.remove('show');
            menu.classList.add('hide');
            arrow.classList.remove('rotated');

            setTimeout(function() {
                menu.style.display = 'none';
                menu.classList.remove('hide');
                isDropdownOpen = false;
            }, 250);
        } else {
            // Buka dropdown
            menu.style.display = 'block';
            menu.classList.remove('hide');
            menu.classList.add('show');
            arrow.classList.add('rotated');
            isDropdownOpen = true;
        }
    }

    // ===== TUTUP DROPDOWN SAAT KLIK DI LUAR =====
    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById('dropdownMenu');
        var toggle = document.querySelector('.dropdown-toggle');
        var arrow = document.getElementById('dropdownArrow');

        if (dropdown && toggle && isDropdownOpen) {
            if (!toggle.contains(event.target) && !dropdown.contains(event.target)) {
                // Tutup dropdown
                dropdown.classList.remove('show');
                dropdown.classList.add('hide');
                arrow.classList.remove('rotated');

                setTimeout(function() {
                    dropdown.style.display = 'none';
                    dropdown.classList.remove('hide');
                    isDropdownOpen = false;
                }, 250);
            }
        }
    });

    // ===== TUTUP DROPDOWN DENGAN TOMBOL ESC =====
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && isDropdownOpen) {
            var dropdown = document.getElementById('dropdownMenu');
            var arrow = document.getElementById('dropdownArrow');

            dropdown.classList.remove('show');
            dropdown.classList.add('hide');
            arrow.classList.remove('rotated');

            setTimeout(function() {
                dropdown.style.display = 'none';
                dropdown.classList.remove('hide');
                isDropdownOpen = false;
            }, 250);
        }
    });
</script>