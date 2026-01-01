@extends('admin.layouts.app')

@section('title', 'Detail Supplier')
@section('page-title', 'Detail Supplier')

@section('content')
<div class="container-fluid" style="background-color: #E8F4F8; min-height: 100vh; padding: 2rem 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.suppliers.index') }}"
                   class="btn btn-link text-decoration-none p-0 text-primary-custom">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-0 rounded-bottom-0">
                <div class="card-body p-4 bg-gradient-primary">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 p-3 rounded">
                            <i class="fas fa-building text-white fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-white bg-opacity-25 text-white">
                                    ID #{{ $supplier->id }}
                                </span>
                                <span class="badge {{ $supplier->jenisBarang->kategori->nama_kategori == 'Medis' ? 'badge-medis' : 'badge-non-medis' }} rounded-pill">
                                    {{ $supplier->jenisBarang->kategori->nama_kategori }}
                                </span>
                            </div>
                            <h3 class="text-white fw-bold mb-0">
                                {{ $supplier->nama_supplier }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body Card -->
            <div class="card border-0 shadow-sm rounded-top-0">
                <div class="card-body p-4">

                    <!-- Info Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card border-custom">
                                <div class="card-body">
                                    <p class="text-secondary small mb-1">
                                        <i class="fas fa-id-card me-1"></i> NIB
                                    </p>
                                    <h5 class="fw-bold mb-0 text-dark">{{ $supplier->nib }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-custom">
                                <div class="card-body">
                                    <p class="text-secondary small mb-1">
                                        <i class="fas fa-tag me-1"></i> Kategori
                                    </p>
                                    <h5 class="fw-bold mb-0 text-dark">
                                        {{ $supplier->jenisBarang->kategori->nama_kategori }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Barang -->
                    <div class="card border-custom mb-4">
                        <div class="card-body">
                            <p class="text-secondary small mb-1">
                                <i class="fas fa-boxes me-1"></i> Jenis Barang
                            </p>
                            <h5 class="fw-bold mb-0 text-dark">
                                {{ $supplier->jenisBarang->nama_jenis }}
                            </h5>
                        </div>
                    </div>

                    <!-- Kontak & WhatsApp Section -->
                    <div class="card border-custom mb-4">
                        <div class="card-body">
                            <p class="text-secondary small mb-2">
                                <i class="fas fa-phone me-1"></i> Kontak Supplier
                            </p>
                            <h5 class="fw-bold mb-3 text-dark">
                                {{ $supplier->kontak }}
                            </h5>

                            @php
                                // Format nomor WhatsApp dengan benar
                                $cleanNumber = preg_replace('/[^0-9]/', '', $supplier->kontak);
                                if (substr($cleanNumber, 0, 1) === '0') {
                                    $cleanNumber = '62' . substr($cleanNumber, 1);
                                }
                                if (substr($cleanNumber, 0, 2) !== '62') {
                                    $cleanNumber = '62' . $cleanNumber;
                                }
                            @endphp

                            <!-- Quick Contact Buttons -->
                            <div class="d-flex gap-2 mb-3">
                                <a href="https://wa.me/{{ $cleanNumber }}"
                                   target="_blank"
                                   class="btn btn-success-custom flex-fill">
                                    <i class="fab fa-whatsapp me-2"></i> Chat Manual
                                </a>

                                <a href="tel:{{ $supplier->kontak }}"
                                   class="btn btn-secondary-custom flex-fill">
                                    <i class="fas fa-phone me-2"></i> Telepon
                                </a>
                            </div>

                            <hr class="my-3">

                            <!-- WhatsApp Template Messages -->
                            <div class="mb-3">
                                <p class="text-secondary small mb-2 fw-bold">
                                    <i class="fas fa-paper-plane me-1"></i> Kirim Pesan Otomatis ke Supplier:
                                </p>
                                <div class="alert alert-info py-2 px-3 mb-3">
                                    <small>
                                        <i class="fas fa-info-circle me-1"></i>
                                        Pesan akan dikirim dari WhatsApp Anda (yang sudah di-scan di Fonnte) ke nomor supplier <strong>{{ $supplier->kontak }}</strong>
                                    </small>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <button type="button"
                                                class="btn btn-outline-success w-100 btn-whatsapp-template"
                                                data-template="info">
                                            <i class="fas fa-info-circle me-1"></i> Info Supplier
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button"
                                                class="btn btn-outline-success w-100 btn-whatsapp-template"
                                                data-template="order">
                                            <i class="fas fa-shopping-cart me-1"></i> Pemesanan
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button"
                                                class="btn btn-outline-success w-100 btn-whatsapp-template"
                                                data-template="payment">
                                            <i class="fas fa-money-bill me-1"></i> Pembayaran
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button"
                                                class="btn btn-outline-success w-100 btn-whatsapp-template"
                                                data-template="reminder">
                                            <i class="fas fa-bell me-1"></i> Pengingat
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-3">

                            <!-- Custom Message -->
                            <div>
                                <p class="text-secondary small mb-2 fw-bold">
                                    <i class="fas fa-edit me-1"></i> Kirim Pesan Custom ke Supplier:
                                </p>
                                <div class="input-group">
                                    <textarea class="form-control"
                                              id="customMessage"
                                              rows="3"
                                              placeholder="Tulis pesan yang akan dikirim ke supplier..."></textarea>
                                </div>
                                <button type="button"
                                        class="btn btn-primary-custom w-100 mt-2"
                                        id="btnSendCustom">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim ke Supplier
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="card border-custom mb-4">
                        <div class="card-body">
                            <p class="text-secondary small mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i> Alamat
                            </p>
                            <p class="mb-0 text-dark lh-lg">
                                {{ $supplier->alamat }}
                            </p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="card border-custom mb-4">
                        <div class="card-body">
                            <p class="text-secondary small mb-1">
                                <i class="fas fa-info-circle me-1"></i> Status
                            </p>
                            <h5 class="mb-0">
                                @if($supplier->status == 'aktif')
                                    <span class="badge badge-status-active">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge badge-status-inactive">
                                        <i class="fas fa-times-circle me-1"></i> Tidak Aktif
                                    </span>
                                @endif
                            </h5>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 pt-3 border-top border-custom">
                        <a href="{{ route('admin.suppliers.index') }}"
                           class="btn btn-secondary-custom flex-fill">
                            <i class="fas fa-times me-2"></i> Tutup
                        </a>
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}"
                           class="btn btn-success-custom flex-fill">
                            <i class="fas fa-edit me-2"></i> Edit Supplier
                        </a>
                    </div>

                </div>
            </div>

            <!-- Footer Info -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body p-3 bg-light-custom">
                    <div class="row text-center small text-secondary">
                        <div class="col-6">
                            <i class="fas fa-calendar-plus me-1"></i>
                            Dibuat: {{ $supplier->created_at->format('d M Y, H:i') }}
                        </div>
                        <div class="col-6">
                            <i class="fas fa-calendar-edit me-1"></i>
                            Diubah: {{ $supplier->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-success mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mb-0 fw-bold">Mengirim WhatsApp...</p>
                <small class="text-muted">Pesan sedang dikirim ke supplier</small>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Color Variables */
    :root {
        --primary-dark: #003D7A;
        --primary-medium: #0066B3;
        --error-color: #E31E24;
        --error-hover: #FF4444;
        --success-color: #1FBD88;
        --success-hover: #1aa876;
        --warning-color: #F59E0B;
        --bg-light: #F5F7FA;
        --bg-very-light: #E8F4F8;
        --text-dark: #1A1A1A;
        --text-secondary: #424242;
        --text-medium: #757575;
        --text-light: #BDBDBD;
        --border-normal: #D0D0D0;
        --border-light: #E0E0E0;
    }

    /* Body Background Override */
    body {
        background-color: var(--bg-very-light) !important;
    }

    /* Main Content Background */
    .container-fluid {
        background-color: var(--bg-very-light) !important;
    }

    /* Background Gradient - Biru */
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
    }

    /* Cards */
    .card {
        transition: all 0.3s ease;
        background-color: white;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .border-custom {
        border: 1px solid var(--border-light);
    }

    /* Badges */
    .badge-medis {
        background-color: var(--success-color);
        color: white;
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-non-medis {
        background-color: var(--primary-medium);
        color: white;
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-status-active {
        background-color: var(--success-color);
        color: white;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .badge-status-inactive {
        background-color: var(--text-medium);
        color: white;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
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

    .btn-success-custom {
        background-color: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    .btn-success-custom:hover {
        background-color: var(--success-hover);
        border-color: var(--success-hover);
        color: white;
    }

    .btn-secondary-custom {
        background-color: var(--text-medium);
        border-color: var(--text-medium);
        color: white;
    }

    .btn-secondary-custom:hover {
        background-color: var(--text-secondary);
        border-color: var(--text-secondary);
        color: white;
    }

    .btn-outline-success {
        color: var(--success-color);
        border-color: var(--success-color);
    }

    .btn-outline-success:hover {
        background-color: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    /* WhatsApp Template Buttons */
    .btn-whatsapp-template {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }

    .btn-whatsapp-template:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Form Controls */
    .form-control {
        border: 1px solid var(--border-normal);
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--success-color);
        box-shadow: 0 0 0 0.2rem rgba(31, 189, 136, 0.25);
    }

    /* Alert */
    .alert-info {
        background-color: #E3F2FD;
        border-color: #90CAF9;
        color: #1565C0;
        font-size: 0.875rem;
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

    .text-primary-custom {
        color: var(--primary-medium) !important;
    }

    /* Background Colors */
    .bg-light-custom {
        background-color: var(--bg-light) !important;
    }

    .bg-white.bg-opacity-25 {
        background-color: rgba(255, 255, 255, 0.25) !important;
    }

    /* Border */
    .border-top.border-custom {
        border-top: 1px solid var(--border-light) !important;
    }

    /* Rounded */
    .rounded-top-0 {
        border-top-left-radius: 0 !important;
        border-top-right-radius: 0 !important;
    }

    .rounded-bottom-0 {
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    /* Line Height */
    .lh-lg {
        line-height: 1.75;
    }

    /* Link */
    a.btn-link {
        transition: color 0.2s ease;
        font-weight: 500;
    }

    a.btn-link:hover {
        color: var(--primary-dark) !important;
        text-decoration: underline !important;
    }

    /* Loading Spinner */
    .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }

        .col-6 {
            font-size: 0.75rem;
        }

        .bg-gradient-primary h3 {
            font-size: 1.25rem;
        }

        .btn-whatsapp-template {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const supplierId = {{ $supplier->id }};
    const csrfToken = '{{ csrf_token() }}';

    // Kirim Template Message
    document.querySelectorAll('.btn-whatsapp-template').forEach(button => {
        button.addEventListener('click', function() {
            const templateType = this.getAttribute('data-template');
            sendTemplateMessage(templateType);
        });
    });

    // Kirim Custom Message
    document.getElementById('btnSendCustom').addEventListener('click', function() {
        const message = document.getElementById('customMessage').value.trim();

        if (!message) {
            Swal.fire({
                icon: 'warning',
                title: 'Pesan Kosong',
                text: 'Mohon tulis pesan terlebih dahulu!',
                confirmButtonColor: '#1FBD88'
            });
            return;
        }

        if (message.length < 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Pesan Terlalu Pendek',
                text: 'Pesan minimal 10 karakter!',
                confirmButtonColor: '#1FBD88'
            });
            return;
        }

        sendCustomMessage(message);
    });

    // Function: Send Template Message
    function sendTemplateMessage(templateType) {
        disableButtons(true);

        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();

        fetch(`/admin/suppliers/${supplierId}/whatsapp/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                template_type: templateType
            })
        })
        .then(response => response.json())
        .then(data => {
            loadingModal.hide();
            disableButtons(false);

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Dikirim!',
                    html: `Pesan telah dikirim ke WhatsApp supplier:<br><strong>{{ $supplier->kontak }}</strong>`,
                    confirmButtonColor: '#1FBD88'
                });
            } else {
                throw new Error(data.message || 'Gagal mengirim pesan');
            }
        })
        .catch(error => {
            loadingModal.hide();
            disableButtons(false);

            Swal.fire({
                icon: 'error',
                title: 'Gagal Mengirim',
                text: error.message || 'Terjadi kesalahan saat mengirim WhatsApp',
                confirmButtonColor: '#E31E24'
            });
        });
    }

    // Function: Send Custom Message
    function sendCustomMessage(message) {
        const btnSend = document.getElementById('btnSendCustom');
        btnSend.disabled = true;
        btnSend.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();

        fetch(`/admin/suppliers/${supplierId}/whatsapp/custom`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            loadingModal.hide();
            btnSend.disabled = false;
            btnSend.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim ke Supplier';

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Dikirim!',
                    html: `Pesan telah dikirim ke WhatsApp supplier:<br><strong>{{ $supplier->kontak }}</strong>`,
                    confirmButtonColor: '#1FBD88'
                });

                document.getElementById('customMessage').value = '';
            } else {
                throw new Error(data.message || 'Gagal mengirim pesan');
            }
        })
        .catch(error => {
            loadingModal.hide();
            btnSend.disabled = false;
            btnSend.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim ke Supplier';

            Swal.fire({
                icon: 'error',
                title: 'Gagal Mengirim',
                text: error.message || 'Terjadi kesalahan saat mengirim WhatsApp',
                confirmButtonColor: '#E31E24'
            });
        });
    }

    // Helper: Disable/Enable Buttons
    function disableButtons(disable) {
        document.querySelectorAll('.btn-whatsapp-template').forEach(btn => {
            btn.disabled = disable;
        });
    }
</script>
@endpush
@endsection
