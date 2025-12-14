<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cherry Pet Clinic</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #F5F7FA;
        }

        .navbar {
            background: linear-gradient(135deg, #0066B3 0%, #003D7A 100%);
            padding: 20px 40px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar .user-name {
            font-size: 14px;
        }

        .navbar .role-badge {
            background: #E31E24;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .logout-btn {
            background: white;
            color: #0066B3;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: #F5F7FA;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .welcome-card h2 {
            color: #1A1A1A;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .welcome-card p {
            color: #757575;
            font-size: 14px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #0066B3;
        }

        .stat-card h3 {
            color: #757575;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .stat-card .number {
            color: #1A1A1A;
            font-size: 32px;
            font-weight: 600;
        }

        .admin-menu {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .admin-menu h3 {
            color: #1A1A1A;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .menu-item {
            padding: 20px;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .menu-item:hover {
            border-color: #0066B3;
            background: #F5F7FA;
            transform: translateY(-2px);
        }

        .menu-item svg {
            color: #0066B3;
            margin-bottom: 10px;
        }

        .menu-item h4 {
            color: #1A1A1A;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🐾 Cherry Pet Clinic - Admin Panel</h1>
        <div class="user-info">
            <span class="user-name">{{ auth()->user()->name }}</span>
            <span class="role-badge">ADMIN</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-card">
            <h2>Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
            <p>Email: {{ auth()->user()->email }} | Role: Administrator</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Pasien</h3>
                <div class="number">245</div>
            </div>
            <div class="stat-card">
                <h3>Janji Hari Ini</h3>
                <div class="number">12</div>
            </div>
            <div class="stat-card">
                <h3>Staff Aktif</h3>
                <div class="number">8</div>
            </div>
            <div class="stat-card">
                <h3>Pendapatan Bulan Ini</h3>
                <div class="number">Rp 45JT</div>
            </div>
        </div>

        <div class="admin-menu">
            <h3>Menu Administrator</h3>
            <div class="menu-grid">
                <div class="menu-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <h4>Kelola Staff</h4>
                </div>
                <div class="menu-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <h4>Jadwal</h4>
                </div>
                <div class="menu-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                    <h4>Laporan Keuangan</h4>
                </div>
                <div class="menu-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    <h4>Pengaturan</h4>
                </div>
            </div>
        </div>
    </div>
</body>
</html>