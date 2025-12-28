@extends('staff.layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
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
                <form action="{{ route('staff.profile.update') }}" method="POST">
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
                        <small class="text-muted">Email digunakan untuk login</small>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" value="{{ ucfirst($user->role) }}" disabled>
                        <small class="text-muted">Role tidak dapat diubah</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('staff.profile.show') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-key me-2"></i>Ubah Password</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('staff.profile.password') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                <i class="fas fa-eye" id="current_password_icon"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required minlength="8">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password_icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimal 8 karakter, kombinasi huruf dan angka</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" required minlength="8">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation_icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>Password harus minimal 8 karakter dan mengandung kombinasi huruf serta angka untuk keamanan yang lebih baik.</small>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key me-1"></i> Ubah Password
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
                <p class="text-muted mb-0">{{ ucfirst($user->role) }}</p>
                <small class="text-muted d-block mt-2">
                    Bergabung sejak {{ $user->created_at->format('d M Y') }}
                </small>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="card mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-shield-alt text-primary me-2"></i>Tips Keamanan</h6>
            </div>
            <div class="card-body">
                <ul class="tips-list">
                    <li><i class="fas fa-check text-success me-2"></i>Gunakan password yang kuat dan unik</li>
                    <li><i class="fas fa-check text-success me-2"></i>Jangan bagikan password kepada siapapun</li>
                    <li><i class="fas fa-check text-success me-2"></i>Ubah password secara berkala (3-6 bulan)</li>
                    <li><i class="fas fa-check text-success me-2"></i>Pastikan email yang terdaftar aktif</li>
                    <li><i class="fas fa-check text-success me-2"></i>Logout setelah selesai bekerja</li>
                    <li><i class="fas fa-check text-success me-2"></i>Jangan simpan password di browser</li>
                </ul>
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="card mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle text-info me-2"></i>Informasi</h6>
            </div>
            <div class="card-body">
                <p class="mb-2 small">
                    <i class="fas fa-calendar text-muted me-2"></i>
                    <strong>Bergabung:</strong> {{ $user->created_at->format('d M Y') }}
                </p>
                <p class="mb-2 small">
                    <i class="fas fa-clock text-muted me-2"></i>
                    <strong>Terakhir Update:</strong> {{ $user->updated_at->diffForHumans() }}
                </p>
                <p class="mb-0 small">
                    <i class="fas fa-envelope text-muted me-2"></i>
                    <strong>Email:</strong> {{ $user->email }}
                </p>
            </div>
        </div>
    </div>
</div>

<style>
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

.profile-avatar-large {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #0066B3 0%, #004080 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 32px;
    font-weight: 600;
    margin: 0 auto;
    box-shadow: 0 4px 12px rgba(0, 102, 179, 0.3);
}

.tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tips-list li {
    padding: 8px 0;
    font-size: 13px;
    color: #555;
    border-bottom: 1px solid #f0f0f0;
}

.tips-list li:last-child {
    border-bottom: none;
}

.alert {
    border-radius: 8px;
}

.form-label {
    font-weight: 500;
    color: #1A1A1A;
    margin-bottom: 8px;
}

.form-control:focus {
    border-color: #0066B3;
    box-shadow: 0 0 0 0.2rem rgba(0, 102, 179, 0.25);
}

.btn {
    font-weight: 500;
    transition: all 0.3s;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}
</style>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Validasi password match
document.getElementById('passwordForm')?.addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;

    if (password !== confirmation) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Password Tidak Cocok',
            text: 'Password baru dan konfirmasi password tidak sama!',
            confirmButtonColor: '#0066B3'
        });
    }
});
</script>
@endpush
@endsection
