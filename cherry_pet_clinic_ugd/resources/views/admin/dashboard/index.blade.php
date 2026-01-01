@extends('admin.layouts.app')

@section('title', 'Beranda')
@section('page-title', 'Beranda')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-2 text-dark">Beranda</h4>
                    <p class="text-secondary small mb-0">Dashboard sistem manajemen inventori klinik</p>
                </div>
                <div class="text-secondary">
                    <i class="far fa-calendar-alt me-2"></i>
                    {{ date('d M Y') }}
                </div>
            </div>
        </div>
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
                    <div class="stat-value">{{ number_format($totalStokBarang ?? 0) }}</div>
                    <div class="stat-change {{ ($persentaseStok ?? 0) >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ ($persentaseStok ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format(abs($persentaseStok ?? 0), 1) }}% dari bulan lalu
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
                    <div class="stat-value">{{ $barangKadaluarsa ?? 0 }}</div>
                    <div class="stat-change negative">
                        <i class="fas fa-exclamation-circle"></i> Perlu perhatian
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
                    <div class="stat-value">{{ $pengadaanPending ?? 0 }}</div>
                    <div class="stat-change {{ ($pengadaanPending ?? 0) > 0 ? 'warning' : 'positive' }}">
                        <i class="fas fa-{{ ($pengadaanPending ?? 0) > 0 ? 'hourglass-half' : 'check-circle' }}"></i>
                        {{ ($pengadaanPending ?? 0) > 0 ? 'Menunggu proses' : 'Semua selesai' }}
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
                    <div class="stat-value">{{ $totalPemasok ?? 0 }}</div>
                    <div class="stat-change positive">
                        <i class="fas fa-building"></i> Pemasok aktif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row g-3 mb-4">
        {{-- Visualisasi Data Pengadaan --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm chart-card">
                <div class="card-body">
                    <h6 class="chart-title">Visualisasi Data Pengadaan</h6>
                    <p class="chart-subtitle mb-3">6 bulan terakhir</p>
                    @if(isset($pengadaanChart) && count($pengadaanChart) > 0)
                        <canvas id="pengadaanChart" style="max-height: 300px;"></canvas>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-3x text-light-custom" style="opacity: 0.3;"></i>
                            <p class="text-secondary fw-medium mb-0 mt-3">Belum ada data pengadaan</p>
                            <small class="text-medium">Data akan muncul setelah ada transaksi pengadaan</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Distribusi Stok Berdasarkan Kategori --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm chart-card">
                <div class="card-body">
                    <h6 class="chart-title">Distribusi Stok Berdasarkan Kategori</h6>
                    <p class="chart-subtitle mb-3">Perbandingan kategori barang</p>
                    @if(isset($distribusiKategori) && count($distribusiKategori) > 0)
                        <canvas id="kategoriChart" style="max-height: 300px;"></canvas>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-pie fa-3x text-light-custom" style="opacity: 0.3;"></i>
                            <p class="text-secondary fw-medium mb-0 mt-3">Belum ada data kategori</p>
                            <small class="text-medium">Tambahkan kategori dan stok barang</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Pemasok Teratas --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="section-title mb-0">Pemasok Teratas</h6>
                    <p class="section-subtitle">Berdasarkan total pengadaan</p>
                </div>
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-sm btn-primary-custom">
                    <i class="fas fa-users-cog me-1"></i> Kelola Pemasok
                </a>
            </div>

            <div class="pemasok-list">
                @if(isset($pemasokTeratas) && count($pemasokTeratas) > 0)
                    @foreach($pemasokTeratas as $index => $supplier)
                    <div class="pemasok-item">
                        <div class="pemasok-rank">
                            <span class="rank-number">#{{ $index + 1 }}</span>
                        </div>
                        <div class="pemasok-avatar" style="background-color: {{ ['#FFEBEE', '#E3F2FD', '#FFF3E0', '#E8F5E9'][$index % 4] }};">
                            <i class="fas {{ ['fa-capsules', 'fa-syringe', 'fa-pills', 'fa-flask'][$index % 4] }}"
                               style="color: {{ ['#D32F2F', '#1976D2', '#F57C00', '#388E3C'][$index % 4] }};"></i>
                        </div>
                        <div class="pemasok-info">
                            <div class="pemasok-name">{{ $supplier->nama_supplier }}</div>
                            <div class="pemasok-type">
                                <i class="fas fa-check-circle text-success me-1"></i>
                                Pemasok Aktif
                            </div>
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
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-light-custom" style="opacity: 0.3;"></i>
                        <p class="text-secondary fw-medium mb-2 mt-3">Belum ada data pemasok</p>
                        <small class="text-medium">Tambahkan pemasok dan pengadaan untuk melihat statistik</small>
                        <br>
                        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary-custom btn-sm mt-3">
                            <i class="fas fa-plus me-1"></i> Tambah Pemasok
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Aktivitas & Peringatan --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="section-title mb-0">Aktivitas & Peringatan</h6>
                    <p class="section-subtitle">Notifikasi real-time sistem</p>
                </div>
                <span class="badge bg-primary-custom">{{ isset($aktivitas) ? count($aktivitas) : 0 }} Notifikasi</span>
            </div>

            <div class="aktivitas-list">
                @if(isset($aktivitas) && count($aktivitas) > 0)
                    @foreach($aktivitas as $item)
                    <div class="aktivitas-item aktivitas-{{ $item['type'] }}">
                        <div class="aktivitas-icon bg-{{ $item['color'] }}">
                            <i class="fas {{ $item['icon'] }}"></i>
                        </div>
                        <div class="aktivitas-content">
                            <div class="aktivitas-header">
                                <span class="aktivitas-badge">{{ $item['title'] }}</span>
                                <span class="aktivitas-time">
                                    <i class="far fa-clock me-1"></i>{{ $item['time'] }}
                                </span>
                            </div>
                            <div class="aktivitas-title">{{ $item['message'] }}</div>
                            <div class="aktivitas-detail">{{ $item['detail'] }}</div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash fa-3x text-light-custom" style="opacity: 0.3;"></i>
                        <p class="text-secondary fw-medium mb-2 mt-3">Tidak ada aktivitas terbaru</p>
                        <small class="text-medium">Semua sistem berjalan normal</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if(isset($pengadaanChart) && count($pengadaanChart) > 0)
// Data untuk Chart Pengadaan
const pengadaanData = {!! json_encode($pengadaanChart) !!};
const bulanLabels = pengadaanData.map(item => {
    const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return bulan[item.bulan - 1] || 'N/A';
});
const pengadaanValues = pengadaanData.map(item => item.jumlah || 0);

// Chart Pengadaan (Bar Chart)
const ctxPengadaan = document.getElementById('pengadaanChart');
if (ctxPengadaan) {
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
                barThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            return 'Pengadaan: ' + context.parsed.y + ' PO';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: '#F5F5F5',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
}
@endif

@if(isset($distribusiKategori) && count($distribusiKategori) > 0)
// Data untuk Chart Kategori
const kategoriData = {!! json_encode($distribusiKategori) !!};
const kategoriLabels = kategoriData.map(k => k.nama_kategori || 'Unknown');
const kategoriValues = kategoriData.map(k => k.total_stok || 0);
const totalStok = kategoriValues.reduce((a, b) => a + b, 0);

// Chart Kategori (Doughnut Chart)
const ctxKategori = document.getElementById('kategoriChart');
if (ctxKategori && totalStok > 0) {
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
                    '#98D8C8',
                    '#A8E6CF',
                    '#FFD3B6'
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
                        font: {
                            size: 11
                        },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map((label, i) => {
                                const value = data.datasets[0].data[i];
                                const percentage = totalStok > 0 ? ((value / totalStok) * 100).toFixed(1) : 0;
                                return {
                                    text: `${label}: ${percentage}% (${value})`,
                                    fillStyle: data.datasets[0].backgroundColor[i],
                                    hidden: false,
                                    index: i
                                };
                            });
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const percentage = totalStok > 0 ? ((value / totalStok) * 100).toFixed(1) : 0;
                            return context.label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });
}
@endif
</script>
@endpush

@push('styles')
<style>
    /* Color Variables - Sama dengan Jenis Barang */
    :root {
        --primary-dark: #003D7A;
        --primary-medium: #0066B3;
        --error-color: #E31E24;
        --error-hover: #FF4444;
        --success-color: #1FBD88;
        --warning-color: #F59E0B;
        --bg-light: #F5F7FA;
        --bg-very-light: #E8F4F8;
        --text-dark: #1A1A1A;
        --text-secondary: #424242;
        --text-medium: #757575;
        --text-light: #BDBDBD;
        --border-normal: #D0D0D0;
        --border-light: #E0E0E0;
        --success-bg: #E8F5E9;
        --error-bg: #FFEBEE;
    }

    /* Body Background Override */
    body {
        background-color: var(--bg-very-light) !important;
    }

    /* Main Content Background */
    .container-fluid {
        background-color: var(--bg-very-light) !important;
    }

    /* Text Colors */
    .text-dark {
        color: var(--text-dark) !important;
    }

    .text-secondary {
        color: var(--text-secondary) !important;
    }

    .text-medium {
        color: var(--text-medium) !important;
    }

    .text-light-custom {
        color: var(--text-light) !important;
    }

    .text-primary-custom {
        color: var(--primary-medium) !important;
    }

    /* Card Styling */
    .card {
        transition: all 0.3s ease;
        background-color: white;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Buttons */
    .btn {
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .btn:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-primary-custom {
        background-color: var(--primary-medium);
        border-color: var(--primary-medium);
        color: white;
    }

    .btn-primary-custom:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        color: white;
    }

    .bg-primary-custom {
        background-color: var(--primary-medium) !important;
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
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
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
        flex-shrink: 0;
    }

    .stat-content {
        flex: 1;
        min-width: 0;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--text-medium);
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
        line-height: 1;
    }

    .stat-change {
        font-size: 0.8rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .stat-change.positive {
        color: var(--success-color);
    }

    .stat-change.negative {
        color: var(--error-color);
    }

    .stat-change.warning {
        color: var(--warning-color);
    }

    /* Chart Cards */
    .chart-card .card-body {
        padding: 20px;
    }

    .chart-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .chart-subtitle {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }

    /* Section Title */
    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0;
        margin-top: 4px;
    }

    /* Pemasok List */
    .pemasok-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .pemasok-item {
        background: var(--bg-light);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.2s;
    }

    .pemasok-item:hover {
        background: var(--bg-very-light);
        transform: translateX(4px);
    }

    .pemasok-rank {
        width: 36px;
        text-align: center;
    }

    .rank-number {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-medium);
    }

    .pemasok-avatar {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .pemasok-info {
        flex: 1;
        min-width: 0;
    }

    .pemasok-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pemasok-type {
        font-size: 0.8rem;
        color: var(--text-medium);
    }

    .pemasok-stats {
        text-align: center;
        padding: 0 20px;
        border-right: 1px solid var(--border-normal);
    }

    .pemasok-count {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-medium);
    }

    .pemasok-label {
        font-size: 0.75rem;
        color: var(--text-medium);
    }

    .pemasok-value {
        text-align: right;
        min-width: 180px;
    }

    .value-label {
        font-size: 0.75rem;
        color: var(--text-medium);
        margin-bottom: 2px;
    }

    .value-amount {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-dark);
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

    .aktivitas-item:hover {
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .aktivitas-item.aktivitas-kadaluarsa,
    .aktivitas-item.aktivitas-stok_habis {
        border-left-color: var(--error-color);
        background: var(--error-bg);
    }

    .aktivitas-item.aktivitas-pengadaan,
    .aktivitas-item.aktivitas-kadaluarsa_soon {
        border-left-color: var(--warning-color);
        background: #FFF3E0;
    }

    .aktivitas-item.aktivitas-sukses {
        border-left-color: var(--success-color);
        background: var(--success-bg);
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
        background-color: var(--error-color) !important;
    }

    .bg-warning {
        background-color: var(--warning-color) !important;
    }

    .bg-success {
        background-color: var(--success-color) !important;
    }

    .aktivitas-content {
        flex: 1;
        min-width: 0;
    }

    .aktivitas-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
        gap: 10px;
    }

    .aktivitas-badge {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--primary-medium);
        background: white;
        padding: 4px 12px;
        border-radius: 12px;
        white-space: nowrap;
    }

    .aktivitas-time {
        font-size: 0.75rem;
        color: var(--text-medium);
        white-space: nowrap;
    }

    .aktivitas-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .aktivitas-detail {
        font-size: 0.85rem;
        color: var(--text-medium);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pemasok-stats {
            border-right: none;
            padding: 0 10px;
        }

        .pemasok-value {
            min-width: 120px;
        }

        .stat-value {
            font-size: 1.5rem;
        }
    }
</style>
@endpush
@endsection
