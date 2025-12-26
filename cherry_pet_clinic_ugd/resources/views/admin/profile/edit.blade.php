@extends('admin.layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <!-- Edit Profile Form -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Informasi Profil</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                               placeholder="Contoh: 081234567890">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  id="address" name="address" rows="3"
                                  placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Ubah Password</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Profile Preview -->
        <div class="card">
            <div class="card-body text-center">
                <div class="profile-avatar-large mb-3">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-0">{{ $user->role ?? 'Administrator' }}</p>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="card mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle text-danger"></i> Tips Keamanan</h6>
            </div>
            <div class="card-body">
                <ul class="tips-list">
                    <li>Gunakan password yang kuat dan unik</li>
                    <li>Jangan bagikan password Anda kepada siapapun</li>
                    <li>Ubah password secara berkala</li>
                    <li>Pastikan email yang terdaftar aktif</li>
                    <li>Logout setelah selesai menggunakan sistem</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar-large {
    width: 80px;
    height: 80px;
    background: #E31E24;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 32px;
    font-weight: 600;
    margin: 0 auto;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.tips-list {
    padding-left: 20px;
    margin: 0;
}

.tips-list li {
    margin-bottom: 8px;
    font-size: 13px;
    color: #555;
}

.tips-list li:last-child {
    margin-bottom: 0;
}
</style>
@endsection
