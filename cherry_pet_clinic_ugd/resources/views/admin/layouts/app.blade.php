<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cherry Pet Clinic')</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle" id="menuToggle">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo-section">
            <div class="logo-circle">
                <img src="{{ asset('asset/logo.png') }}" alt="Cherry Pet Clinic Logo" class="logo-img">
            </div>
            <div class="logo-text">
                <h3>Cherry Pet Clinic</h3>
                <p>UGD 24 Jam - Arcawinangun Purwokerto</p>
            </div>
        </div>

        <div class="menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ route('admin.stok_barang.index') }}" class="menu-item {{ request()->routeIs('admin.stok_barang.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>Stok Barang</span>
            </a>

            <a href="{{ route('pengadaan.index') }}" class="menu-item {{ request()->routeIs('pengadaan.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span>Pengadaan Stok</span>
            </a>

            <a href="#" class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Laporan</span>
            </a>

            <a href="{{ route('admin.suppliers.index') }}" class="menu-item {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span>Pemasok</span>
            </a>

            <a href="{{ route('admin.kategori.index') }}" class="menu-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span>Kategori</span>
            </a>
        </div>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>@yield('header-title', 'Sistem Manajemen Inventori Klinik Hewan')</h1>
        </div>

        <div class="header-actions">
            <div class="notification-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="notification-badge">1</span>
            </div>

            <!-- User Profile Dropdown -->
            <div class="dropdown">
                <div class="user-profile" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">A</div>
                    <div class="user-info">
                        <div class="user-name">Admin Name</div>
                        <div class="user-role">Administrator</div>
                    </div>
                    <svg class="dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.staff.index') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>Daftar Staff</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h2>@yield('page-title', 'Beranda')</h2>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .menu-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            width: 40px;
            height: 40px;
            background: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            z-index: 150;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .menu-toggle span {
            width: 20px;
            height: 2px;
            background: #1A1A1A;
            border-radius: 2px;
            transition: all 0.3s;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 165px;
            height: 100vh;
            background: linear-gradient(180deg, #0066B3 0%, #004080 100%);
            padding: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
            overflow-y: auto;
        }

        .logo-section {
            text-align: center;
            padding: 20px 10px;
            background: rgba(0, 0, 0, 0.1);
        }

        .logo-circle {
            width: 55px;
            height: 55px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            padding: 5px;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .logo-circle svg {
            width: 32px;
            height: 32px;
        }

        .logo-text h3 {
            color: white;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .logo-text p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 8px;
            line-height: 1.3;
        }

        .menu {
            padding: 15px 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            margin-bottom: 3px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        .menu-item svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .header {
            position: fixed;
            left: 165px;
            right: 0;
            top: 0;
            height: 60px;
            background: #0066B3;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            z-index: 50;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header-left h1 {
            font-size: 15px;
            color: white;
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .notification-icon:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .notification-icon svg {
            width: 22px;
            height: 22px;
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            min-width: 18px;
            height: 18px;
            background: #E31E24;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 0 5px;
            border: 2px solid #0066B3;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px 12px;
            border-radius: 20px;
            transition: background 0.3s;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: #E31E24;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 12px;
            font-weight: 600;
            color: white;
        }

        .user-role {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.8);
        }

        .dropdown-arrow {
            width: 16px;
            height: 16px;
            color: white;
            margin-left: 5px;
            transition: transform 0.3s;
        }

        .dropdown.show .dropdown-arrow {
            transform: rotate(180deg);
        }

        /* Profile Dropdown Styling */
        .profile-dropdown {
            min-width: 220px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 8px 0;
            margin-top: 8px;
        }

        .profile-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            font-size: 14px;
            color: #1A1A1A;
            transition: all 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .profile-dropdown .dropdown-item:hover {
            background: #f8f9fa;
            color: #0066B3;
        }

        .profile-dropdown .dropdown-item.text-danger:hover {
            background: #fff5f5;
            color: #E31E24;
        }

        .profile-dropdown .dropdown-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .profile-dropdown .dropdown-divider {
            margin: 8px 0;
        }

        .main-content {
            margin-left: 165px;
            margin-top: 60px;
            padding: 0;
            min-height: calc(100vh - 60px);
        }

        .page-header {
            background: white;
            padding: 20px 25px;
            border-bottom: 1px solid #E0E0E0;
        }

        .page-header h2 {
            font-size: 18px;
            color: #1A1A1A;
            font-weight: 600;
        }

        .content-area {
            padding: 25px;
        }

        /* Bootstrap Overrides & Enhancements */
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .form-control, .form-select {
            border-radius: 6px;
            font-size: 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #0066B3;
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 179, 0.25);
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
        }

        .alert {
            border-radius: 8px;
        }

        .table {
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .header {
                left: 0;
                padding: 0 15px 0 65px;
            }

            .header-left h1 {
                font-size: 13px;
            }

            .main-content {
                margin-left: 0;
            }

            .user-info {
                display: none;
            }

            .dropdown-arrow {
                display: none;
            }
        }
    </style>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle?.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });

        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>

    {{-- Bootstrap JS Bundle (includes Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>