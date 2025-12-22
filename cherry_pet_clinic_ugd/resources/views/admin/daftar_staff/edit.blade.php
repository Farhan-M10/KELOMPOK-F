@extends('layouts.app')

@section('title', 'Edit Staff - Cherry Pet Clinic')
@section('page-title', 'Edit Data Staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            {{-- Alert Messages --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Form Edit Data Staff --}}
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>Edit Informasi Staff
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-section mb-4">
                            <h6 class="section-title mb-3">
                                <i class="fas fa-user me-2"></i>Informasi Personal
                            </h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $staff->name) }}"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label">
                                        Role/Jabatan <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('role') is-invalid @enderror"
                                            id="role"
                                            name="role"
                                            required>
                                        <option value="">Pilih Role</option>
                                        <option value="staff" {{ old('role', $staff->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="kasir" {{ old('role', $staff->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                        <option value="dokter" {{ old('role', $staff->role) == 'dokter' ? 'selected' : '' }}>Dokter</option>
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $staff->email) }}"
                                           required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Telepon</label>
                                    <input type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $staff->phone) }}"
                                           placeholder="08xxxxxxxxxx">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address"
                                          name="address"
                                          rows="3">{{ old('address', $staff->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="fas fa-save me-2"></i>Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Form Update Password --}}
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-lock me-2"></i>Ubah Password
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.staff.update-password', $staff->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian!</strong> Ubah password hanya jika diperlukan. Staff akan login menggunakan password baru.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    Password Baru <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required>
                                    <button class="btn btn-outline-secondary"
                                            type="button"
                                            onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-icon"></i>
                                    </button>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Minimal 8 karakter</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           required>
                                    <button class="btn btn-outline-secondary"
                                            type="button"
                                            onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-key me-2"></i>Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-section {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.section-title {
    color: #0066B3;
    font-weight: 600;
    padding-bottom: 10px;
    border-bottom: 2px solid #e0e0e0;
}

.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 8px;
}

.text-danger {
    color: #E31E24 !important;
}
</style>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');

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
</script>
@endpush
@endsection
