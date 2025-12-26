@extends('admin.layouts.app')

@section('title', 'Daftar Staff')
@section('page-title', 'Daftar Staff')

@section('content')
<div class="container-fluid">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter & Search Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.staff.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Pencarian</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama, Email, atau No. Telepon..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="veterinarian" {{ request('role') == 'veterinarian' ? 'selected' : '' }}>Veterinarian</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label d-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Staff Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Data Staff</h5>
            <a href="{{ route('admin.staff.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Staff
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $index => $user)
                        <tr>
                            <td>{{ $staff->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>{!! $user->role_badge !!}</td>
                            <td>{!! $user->status_badge !!}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.staff.show', $user->id) }}" class="action-btn action-btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.staff.edit', $user->id) }}" class="action-btn action-btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.staff.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus staff ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Tidak ada data staff</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $staff->firstItem() ?? 0 }} - {{ $staff->lastItem() ?? 0 }} dari {{ $staff->total() }} data
                </div>
                <div>
                    {{ $staff->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.action-buttons {
    display: flex;
    gap: 6px;
    justify-content: center;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: 1px solid;
    border-radius: 6px;
    background: white;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    padding: 0;
    font-size: 14px;
}

/* Detail Button - Biru */
.action-btn-info {
    color: #0066B3;
    border-color: #0066B3;
}

.action-btn-info:hover {
    background: #0066B3;
    color: white;
}

/* Edit Button - Kuning/Orange */
.action-btn-warning {
    color: #F59E0B;
    border-color: #F59E0B;
}

.action-btn-warning:hover {
    background: #F59E0B;
    color: white;
}

/* Delete Button - Merah */
.action-btn-danger {
    color: #E31E24;
    border-color: #E31E24;
}

.action-btn-danger:hover {
    background: #E31E24;
    color: white;
}

.action-btn i {
    font-size: 13px;
}
</style>
@endsection
