@extends('layouts.app')

@section('title', 'Detail Staff - Cherry Pet Clinic')
@section('page-title', 'Detail Staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            {{-- Staff Profile Card --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="profile-avatar-large">
                                {{ strtoupper(substr($staff->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="col">
                            <h4 class="mb-1">{{ $staff->name }}</h4>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                @php
                                    $roleColors = [
                                        'staff' => 'info',
                                        'kasir' => 'warning',
                                        'dokter' => 'success',
                                        'admin' => 'danger'
                                    ];
                                    $color = $roleColors[$staff->role] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">
                                    <i class="fas fa-user-tag me-1"></i>
                                    {{ ucfirst($staff->role) }}
                                </span>
                                <span class="badge bg-{{ $staff->is_active ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $staff->is_active ? 'check-circle' : 'times-circle' }} me-1"></i>
                                    {{ $staff->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Bergabung sejak {{ $staff->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.staff.edit', $staff->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Contact Information --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-address-card me-2"></i>Informasi Kontak
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-envelope text-primary"></i>
                                    Email
                                </div>
                                <div class="info-value">{{ $staff->email }}</div>
                            </div>
                            <hr>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-phone text-success"></i>
                                    Telepon
                                </div>
                                <div class="info-value">{{ $staff->phone ?? '-' }}</div>
                            </div>
                            <hr>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                    Alamat
                                </div>
                                <div class="info-value">{{ $staff->address ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Account Information --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-user-cog me-2"></i>Informasi Akun
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-id-badge text-primary"></i>
                                    ID Staff
                                </div>
                                <div class="info-value">{{ $staff->id }}</div>
                            </div>
                            <hr>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-user-shield text-warning"></i>
                                    Role/Jabatan
                                </div>
                                <div class="info-value">{{ ucfirst($staff->role) }}</div>
                            </div>
                            <hr>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-toggle-on text-success"></i>
                                    Status Akun
                                </div>
                                <div class="info-value">
                                    <form action="{{ route('admin.staff.toggle-status', $staff->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn btn-sm btn-{{ $staff->is_active ? 'success' : 'secondary' }}">
                                            <i class="fas fa-{{ $staff->is_active ? 'check' : 'times' }} me-1"></i>
                                            {{ $staff->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-clock text-info"></i>
                                    Terakhir Update
                                </div>
                                <div class="info-value">{{ $staff->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <div class="btn-group">
                            <a href="{{ route('admin.staff.edit', $staff->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            @if($staff->role !== 'admin')
                            <button type="button"
                                    class="btn btn-danger"
                                    onclick="confirmDelete()">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                            @endif
                        </div>
                    </div>

                    @if($staff->role !== 'admin')
                    <form id="delete-form"
                          action="{{ route('admin.staff.destroy', $staff->id) }}"
                          method="POST"
                          class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar-large {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #0066B3, #004080);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 36px;
    box-shadow: 0 4px 12px rgba(0, 102, 179, 0.3);
}

.info-item {
    padding: 8px 0;
}

.info-label {
    font-weight: 500;
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 5px;
}

.info-label i {
    width: 20px;
    margin-right: 8px;
}

.info-value {
    font-size: 15px;
    color: #1A1A1A;
    font-weight: 500;
}

.card-header h6 {
    font-weight: 600;
}
</style>

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus staff ini? Data yang dihapus tidak dapat dikembalikan!')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush
@endsection
