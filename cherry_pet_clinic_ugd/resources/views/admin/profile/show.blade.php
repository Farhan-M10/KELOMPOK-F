@extends('admin.layouts.app')

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
                <p class="text-muted mb-3">{{ $user->role ?? 'Administrator' }}</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
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
                        <p class="mb-0">{{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : 'Baru saja' }}</p>
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
                        <strong>No. Telepon:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $user->phone ?? '-' }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Alamat:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $user->address ?? '-' }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Role:</strong>
                    </div>
                    <div class="col-md-8">
                        <span class="badge bg-primary">{{ $user->role ?? 'Administrator' }}</span>
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
                        <small class="text-muted">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Baru saja' }}</small>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon bg-success">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div class="activity-content">
                        <p class="mb-0">Profil diperbarui</p>
                        <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
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
    background: #E31E24;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 36px;
    font-weight: 600;
    margin: 0 auto;
    box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
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
</style>
@endsection
