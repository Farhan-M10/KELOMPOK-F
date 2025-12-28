@extends('staff.layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card">
            <div class="card-body text-center">
                <div class="profile-avatar-large mb-3">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ ucfirst($user->role) }}</p>
                <a href="{{ route('staff.profile.edit') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Informasi Akun</h6>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <i class="fas fa-calendar-alt text-primary"></i>
                    <div>
                        <small class="text-muted">Bergabung Sejak</small>
                        <p class="mb-0">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock text-success"></i>
                    <div>
                        <small class="text-muted">Terakhir Login</small>
                        <p class="mb-0">{{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : 'Baru saja' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Detail Information Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Informasi Detail</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama Lengkap:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $user->name }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $user->email }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Role:</strong>
                    </div>
                    <div class="col-md-8">
                        <span class="badge bg-info">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Status Akun:</strong>
                    </div>
                    <div class="col-md-8">
                        <span class="badge bg-success">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Card -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Aktivitas Terakhir</h6>
            </div>
            <div class="card-body">
                <div class="activity-item">
                    <div class="activity-icon bg-primary">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div class="activity-content">
                        <p class="mb-0">Login ke sistem</p>
                        <small class="text-muted">{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'Baru saja' }}</small>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon bg-success">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="activity-content">
                        <p class="mb-0">Akses pengurangan stok</p>
                        <small class="text-muted">{{ now()->diffForHumans() }}</small>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon bg-warning">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="activity-content">
                        <p class="mb-0">Melihat laporan</p>
                        <small class="text-muted">{{ now()->subHours(2)->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('staff.pengurangan_stok.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-minus-circle me-2"></i>
                            Pengurangan Stok
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="btn btn-outline-info w-100">
                            <i class="fas fa-file-alt me-2"></i>
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar-large {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #0066B3 0%, #004080 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 36px;
    font-weight: 600;
    margin: 0 auto;
    box-shadow: 0 4px 12px rgba(0, 102, 179, 0.3);
}

.card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
}

.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
    padding: 15px 20px;
}

.card-header h6 {
    color: #1A1A1A;
    font-weight: 600;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 0;
}

.info-item:not(:last-child) {
    border-bottom: 1px solid #f0f0f0;
}

.info-item i {
    font-size: 24px;
    width: 30px;
    text-align: center;
}

.activity-item {
    display: flex;
    align-items: start;
    gap: 15px;
    padding: 12px 0;
}

.activity-item:not(:last-child) {
    border-bottom: 1px solid #f0f0f0;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-content p {
    font-weight: 500;
    color: #1A1A1A;
}

.badge {
    padding: 6px 12px;
    font-weight: 500;
    font-size: 12px;
}

.btn {
    font-weight: 500;
    transition: all 0.3s;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

hr {
    margin: 0;
    border-color: #f0f0f0;
}
</style>
@endsection
