{{-- File: resources/views/admin/dashboard/index.blade.php --}}

@extends('admin.layouts.app')

@section('content')
<div class="container-fluid dashboard-container">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="dashboard-title mb-0">Beranda</h2>
    </div>

    {{-- Statistik Cards --}}
    <div class="row g-3 mb-4">
        {{-- Total Stok Barang --}}
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #E3F2FD;">
                    <i class="fas fa-boxes" style="color: #1976D2;"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Stok Barang</div>
                    <div class="stat-value">{{ number_format($totalStokBarang) }}</div>
                    <div class="stat-change {{ $persentaseStok >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $persentaseStok >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format(abs($persentaseStok), 1) }}%
                    </div>
                </div>
            </div>
        </div>

        {{-- Barang Kadaluarsa --}}
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #FFEBEE;">
                    <i class="fas fa-exclamation-triangle" style="color: #D32F2F;"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Barang Kadaluarsa</div>
                    <div class="stat-value">{{ $barangKadaluarsa }}</div>
                    <div class="stat-change negative">
                        <i class="fas fa-arrow-up"></i> +4
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengadaan Pending --}}
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #FFF3E0;">
                    <i class="fas fa-clock" style="color: #F57C00;"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Pengadaan Pending</div>
                    <div class="stat-value">{{ $pengadaanPending }}</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-down"></i> +10%
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pemasok --}}
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #E8F5E9;">
                    <i class="fas fa-users" style="color: #388E3C;"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Pemasok</div>
                    <div class="stat-value">{{ $totalPemasok }}</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +28
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row g-3 mb-4">
        {{-- Visualisasi Data Pengadaan --}}
        <div class="col-md-7">
            <div class="card chart-card">
                <div class="card-body">
                    <h6 class="chart-title">Visualisasi Data Pengadaan (6 bulan terakhir)</h6>
                    <canvas id="pengadaanChart" height="280"></canvas>
                </div>
            </div>
        </div>

        {{-- Distribusi Stok Berdasarkan Kategori --}}
        <div class="col-md-5">
            <div class="card chart-card">
                <div class="card-body">
                    <h6 class="chart-title">Distribusi Stok Berdasarkan Kategori</h6>
                    <p class="chart-subtitle">Perbandingan kategori barang</p>
                    <canvas id="kategoriChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Pemasok Teratas --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="section-title mb-0">Pemasok Teratas</h6>
                <a href="{{ route('admin.suppliers.index') }}" class="view-all-link">
                    <i class="fas fa-users-cog"></i>
                </a>
            </div>

            <div class="pemasok-list">
                @forelse($pemasokTeratas as $index => $supplier)
                <div class="pemasok-item">
                    <div class="pemasok-avatar" style="background-color: {{ ['#FFEBEE', '#E3F2FD', '#FFF3E0', '#E8F5E9'][$index % 4] }};">
                        <i class="fas {{ ['fa-capsules', 'fa-syringe', 'fa-dog', 'fa-cut'][$index % 4] }}"
                           style="color: {{ ['#D32F2F', '#1976D2', '#F57C00', '#388E3C'][$index % 4] }};"></i>
                    </div>
                    <div class="pemasok-info">
                        <div class="pemasok-name">{{ $supplier->nama_supplier }}</div>
                        <div class="pemasok-type">Pemasok Aktif</div>
                    </div>
                    <div class="pemasok-stats">
                        <div class="pemasok-count">{{ $supplier->pengadaans_count ?? 0 }}</div>
                        <div class="pemasok-label">Total PO</div>
                    </div>
                    <div class="pemasok-value">
                        <div class="value-label">Total Nilai</div>
                        <div class="value-amount">
                            Rp {{ number_format($supplier->total_nilai ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Belum ada data pemasok</p>
                    <small class="text-muted">Tambahkan pemasok dan pengadaan untuk melihat statistik</small>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Aktivitas & Peringatan --}}
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="section-title mb-0">Aktivitas & Peringatan</h6>
                    <p class="section-subtitle">Real-time Notification</p>
                </div>
            </div>

            <div class="aktivitas-list">
                @forelse($aktivitas as $item)
                <div class="aktivitas-item aktivitas-{{ $item['type'] }}">
                    <div class="aktivitas-icon bg-{{ $item['color'] }}">
                        <i class="fas {{ $item['icon'] }}"></i>
                    </div>
                    <div class="aktivitas-content">
                        <div class="aktivitas-header">
                            <span class="aktivitas-badge">{{ $item['title'] }}</span>
                            <span class="aktivitas-time">{{ $item['time'] }}</span>
                        </div>
                        <div class="aktivitas-title">{{ $item['message'] }}</div>
                        <div class="aktivitas-detail">{{ $item['detail'] }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada aktivitas terbaru</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data untuk Chart Pengadaan
const pengadaanData = {!! json_encode($pengadaanChart) !!};
const bulanLabels = pengadaanData.map(item => {
    const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return bulan[item.bulan - 1];
});
const pengadaanValues = pengadaanData.map(item => item.jumlah);

// Chart Pengadaan (Bar Chart)
const ctxPengadaan = document.getElementById('pengadaanChart').getContext('2d');
new Chart(ctxPengadaan, {
    type: 'bar',
    data: {
        labels: bulanLabels,
        datasets: [{
            label: 'Jumlah Pengadaan',
            data: pengadaanValues,
            backgroundColor: [
                '#9575CD',
                '#FF8A80',
                '#4FC3F7',
                '#FFB74D',
                '#81C784',
                '#64B5F6'
            ],
            borderRadius: 8,
            barThickness: 40
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 10
                },
                grid: {
                    color: '#F5F5F5'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Data untuk Chart Kategori
const kategoriData = {!! json_encode($distribusiKategori) !!};
const kategoriLabels = kategoriData.map(k => k.nama_kategori);
const kategoriValues = kategoriData.map(k => k.total_stok || 0);
const totalStok = kategoriValues.reduce((a, b) => a + b, 0);

// Chart Kategori (Doughnut Chart)
const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
new Chart(ctxKategori, {
    type: 'doughnut',
    data: {
        labels: kategoriLabels,
        datasets: [{
            data: kategoriValues,
            backgroundColor: [
                '#FF6B6B',
                '#4ECDC4',
                '#45B7D1',
                '#FFA07A',
                '#98D8C8'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    generateLabels: function(chart) {
                        const data = chart.data;
                        return data.labels.map((label, i) => {
                            const value = data.datasets[0].data[i];
                            const percentage = ((value / totalStok) * 100).toFixed(0);
                            return {
                                text: `${label}: ${percentage}%`,
                                fillStyle: data.datasets[0].backgroundColor[i],
                                hidden: false,
                                index: i
                            };
                        });
                    }
                }
            }
        },
        cutout: '70%'
    }
});
</script>
@endpush

@push('styles')
<style>
.dashboard-container {
    background-color: #E8F4F8;
    min-height: 100vh;
    padding: 20px;
}

.dashboard-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #1A1A1A;
}

/* Statistik Cards */
.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: #757575;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1A1A1A;
    margin-bottom: 4px;
}

.stat-change {
    font-size: 0.875rem;
    font-weight: 500;
}

.stat-change.positive {
    color: #388E3C;
}

.stat-change.negative {
    color: #D32F2F;
}

/* Chart Cards */
.chart-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    height: 100%;
}

.chart-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1A1A1A;
    margin-bottom: 4px;
}

.chart-subtitle {
    font-size: 0.875rem;
    color: #757575;
    margin-bottom: 20px;
}

/* Section Title */
.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1A1A1A;
}

.section-subtitle {
    font-size: 0.875rem;
    color: #757575;
    margin-bottom: 0;
    margin-top: 4px;
}

.view-all-link {
    color: #0066B3;
    font-size: 1.25rem;
    transition: color 0.2s;
}

.view-all-link:hover {
    color: #003D7A;
}

/* Pemasok List */
.pemasok-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.pemasok-item {
    background: #F5F7FA;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.2s;
}

.pemasok-item:hover {
    background: #E8F4F8;
    transform: translateX(4px);
}

.pemasok-avatar {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.pemasok-info {
    flex: 1;
}

.pemasok-name {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1A1A1A;
}

.pemasok-type {
    font-size: 0.8rem;
    color: #757575;
}

.pemasok-stats {
    text-align: center;
    padding: 0 20px;
    border-right: 1px solid #D0D0D0;
}

.pemasok-count {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0066B3;
}

.pemasok-label {
    font-size: 0.75rem;
    color: #757575;
}

.pemasok-value {
    text-align: right;
    min-width: 180px;
}

.value-label {
    font-size: 0.75rem;
    color: #757575;
    margin-bottom: 2px;
}

.value-amount {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1A1A1A;
}

/* Aktivitas List */
.aktivitas-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.aktivitas-item {
    background: white;
    border-left: 4px solid;
    border-radius: 8px;
    padding: 16px;
    display: flex;
    gap: 15px;
    transition: all 0.2s;
}

.aktivitas-item.aktivitas-kadaluarsa {
    border-left-color: #D32F2F;
    background: #FFEBEE;
}

.aktivitas-item.aktivitas-stok_habis {
    border-left-color: #D32F2F;
    background: #FFEBEE;
}

.aktivitas-item.aktivitas-pengadaan {
    border-left-color: #F57C00;
    background: #FFF3E0;
}

.aktivitas-item.aktivitas-sukses {
    border-left-color: #388E3C;
    background: #E8F5E9;
}

.aktivitas-item.aktivitas-kadaluarsa_soon {
    border-left-color: #F57C00;
    background: #FFF3E0;
}

.aktivitas-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    flex-shrink: 0;
}

.bg-danger {
    background-color: #D32F2F !important;
}

.bg-warning {
    background-color: #F57C00 !important;
}

.bg-success {
    background-color: #388E3C !important;
}

.aktivitas-content {
    flex: 1;
}

.aktivitas-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}

.aktivitas-badge {
    font-size: 0.75rem;
    font-weight: 600;
    color: #0066B3;
    background: white;
    padding: 4px 12px;
    border-radius: 12px;
}

.aktivitas-time {
    font-size: 0.75rem;
    color: #757575;
}

.aktivitas-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1A1A1A;
    margin-bottom: 4px;
}

.aktivitas-detail {
    font-size: 0.85rem;
    color: #757575;
}

/* Card styling */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
</style>
@endpush
@endsection
