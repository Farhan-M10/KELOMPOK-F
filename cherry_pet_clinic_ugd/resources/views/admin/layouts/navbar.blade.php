<nav class="navbar">
    <div class="navbar-left">
        <h1>{{ $title ?? 'Sistem Manajemen Inventori Klinik Hewan' }}</h1>
    </div>

    <div class="navbar-right">
        <!-- Notification Icon -->
        <div class="notification-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="badge">3</span>
        </div>

        <!-- User Dropdown -->
        <div class="user-dropdown">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-role">{{ ucfirst(auth()->user()->role) }}</span>
            </div>

            <!-- Dropdown Menu -->
            <div class="dropdown-content">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Profil
                </a>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    Pengaturan
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar {
        height: 70px;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 30px;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .navbar-left h1 {
        font-size: 18px;
        color: #1A1A1A;
        font-weight: 600;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .notification-icon {
        position: relative;
        cursor: pointer;
        color: #757575;
        transition: color 0.3s;
    }

    .notification-icon:hover {
        color: #0066B3;
    }

    .notification-icon .badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #E31E24;
        color: white;
        font-size: 10px;
        font-weight: 600;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-dropdown {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        position: relative;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #E31E24 0%, #FF4444 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-size: 14px;
        color: #1A1A1A;
        font-weight: 600;
    }

    .user-role {
        font-size: 12px;
        color: #757575;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        top: 60px;
        right: 0;
        background: white;
        min-width: 200px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        z-index: 1000;
    }

    .user-dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-content a,
    .dropdown-logout {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        color: #1A1A1A;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.2s;
        width: 100%;
        border: none;
        background: none;
        cursor: pointer;
        text-align: left;
    }

    .dropdown-content a:hover,
    .dropdown-logout:hover {
        background: #F5F7FA;
    }

    .dropdown-divider {
        height: 1px;
        background: #E0E0E0;
        margin: 5px 0;
    }

    .dropdown-logout {
        color: #E31E24;
    }

    .dropdown-logout:hover {
        background: #FFEBEE;
    }
</style>
