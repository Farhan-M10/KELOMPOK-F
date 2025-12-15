<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cherry Pet Clinic')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-50">
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
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C10.3431 2 9 3.34315 9 5C9 6.65685 10.3431 8 12 8C13.6569 8 15 6.65685 15 5C15 3.34315 13.6569 2 12 2Z" fill="#E31E24"/>
                    <path d="M7 9C5.34315 9 4 10.3431 4 12C4 13.6569 5.34315 15 7 15C8.65685 15 10 13.6569 10 12C10 10.3431 8.65685 9 7 9Z" fill="#E31E24"/>
                    <path d="M14 12C14 10.3431 15.3431 9 17 9C18.6569 9 20 10.3431 20 12C20 13.6569 18.6569 15 17 15C15.3431 15 14 13.6569 14 12Z" fill="#E31E24"/>
                    <path d="M9 19C9 17.3431 10.3431 16 12 16C13.6569 16 15 17.3431 15 19C15 20.6569 13.6569 22 12 22C10.3431 22 9 20.6569 9 19Z" fill="#E31E24"/>
                </svg>
            </div>
            <div class="logo-text">
                <h3>Cherry Pet Clinic</h3>
                <p>UGD 24 Jam - Purwokerto</p>
            </div>
        </div>

        <div class="menu">
            <a href="{{ route('admin.suppliers.index') }}" class="menu-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="#" class="menu-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>Stok Barang</span>
            </a>

            <a href="#" class="menu-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span>Pengadaan Stok</span>
            </a>

            <a href="#" class="menu-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Laporan</span>
            </a>

            <a href="{{ route('admin.suppliers.index') }}" class="menu-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span>Supplier</span>
            </a>

            <a href="#" class="menu-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span>Kategori</span>
            </a>
        </div>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="header-title">
            <h1>@yield('page-title', 'Dashboard')</h1>
        </div>

        <div class="header-actions">
            <div class="notification-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="notification-badge"></span>
            </div>

            <div class="user-profile">
                <div class="user-avatar">A</div>
                <div class="user-info">
                    <div class="user-name">Admin</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <style>
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
            width: 240px;
            height: 100vh;
            background: linear-gradient(180deg, #0066B3 0%, #003D7A 100%);
            padding: 20px 0;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 100;
            overflow-y: auto;
        }

        .logo-section {
            text-align: center;
            padding: 0 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 15px;
        }

        .logo-circle {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .logo-circle svg {
            width: 35px;
            height: 35px;
        }

        .logo-text h3 {
            color: white;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .logo-text p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 10px;
        }

        .menu {
            padding: 0 12px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 4px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(3px);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .menu-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .header {
            position: fixed;
            left: 240px;
            right: 0;
            top: 0;
            height: 60px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            z-index: 50;
        }

        .header-title h1 {
            font-size: 16px;
            color: #1A1A1A;
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
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
            background: #F5F7FA;
        }

        .notification-icon svg {
            width: 20px;
            height: 20px;
            color: #424242;
        }

        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #E31E24;
            border-radius: 50%;
            border: 2px solid white;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 25px;
            transition: background 0.3s;
        }

        .user-profile:hover {
            background: #F5F7FA;
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
            font-size: 13px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 12px;
            font-weight: 600;
            color: #1A1A1A;
        }

        .user-role {
            font-size: 10px;
            color: #757575;
        }

        .main-content {
            margin-left: 240px;
            margin-top: 60px;
            padding: 25px;
            min-height: calc(100vh - 60px);
            max-width: 1400px;
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

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .user-info {
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

    @stack('scripts')
</body>
</html>
