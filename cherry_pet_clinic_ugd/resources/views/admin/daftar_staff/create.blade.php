@extends('layouts.app')

@section('title', 'Daftar Staff - Cherry Pet Clinic')
@section('page-title', 'Daftar Staff')

@section('content')
<div class="container-fluid">
    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Header Section --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users text-primary me-2"></i>
                        Manajemen Staff
                    </h5>
                    <p class="text-muted small mb-0">Kelola data staff klinik</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Staff
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Staff Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="20%">Email</th>
                            <th width="15%">Telepon</th>
                            <th width="12%">Role</th>
                            <th width="10%">Status</th>
                            <th width="18%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $index => $item)
                        <tr>
                            <td>{{ $staff->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $item->name }}</div>
                                        <small class="text-muted">ID: {{ $item->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone ?? '-' }}</td>
                            <td>
                                @php
                                    $roleColors = [
                                        'staff' => 'info',
                                        'kasir' => 'warning',
                                        'dokter' => 'success'
                                    ];
                                    $color = $roleColors[$item->role] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">
                                    {{ ucfirst($item->role) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.staff.toggle-status', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-{{ $item->is_active ? 'success' : 'secondary' }} btn-status">
                                        <i class="fas fa-{{ $item->is_active ? 'check' : 'times' }}"></i>
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.staff.show', $item->id) }}"
                                       class="btn btn-sm btn-info"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.staff.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="confirmDelete({{ $item->id }})"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $item->id }}"
                                      action="{{ route('admin.staff.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data staff</p>
                                <a href="{{ route('admin.staff.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Staff Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($staff->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Menampilkan {{ $staff->firstItem() }} - {{ $staff->lastItem() }} dari {{ $staff->total() }} staff
                </div>
                <div>
                    {{ $staff->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #0066B3, #004080);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 16px;
}

.btn-status {
    min-width: 80px;
    border: none;
}

.table th {
    font-weight: 600;
    color: #495057;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    font-size: 14px;
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-radius: 4px 0 0 4px;
}

.btn-group .btn:last-child {
    border-radius: 0 4px 4px 0;
}
</style>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus staff ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection
