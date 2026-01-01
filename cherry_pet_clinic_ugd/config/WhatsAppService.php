<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $token;
    protected $url;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->url = config('services.fonnte.url');
    }

    /**
     * Format nomor telepon ke format internasional
     */
    public function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Kirim pesan teks biasa
     */
    public function sendMessage($target, $message)
    {
        try {
            $target = $this->formatPhoneNumber($target);

            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->url, [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                $result = $response->json();

                Log::info('WhatsApp sent successfully', [
                    'target' => $target,
                    'response' => $result
                ]);

                return [
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim',
                    'data' => $result
                ];
            } else {
                throw new \Exception('API Error: ' . $response->body());
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp Error', [
                'target' => $target ?? 'unknown',
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengirim pesan: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Kirim pesan dengan gambar
     */
    public function sendImage($target, $message, $imageUrl)
    {
        try {
            $target = $this->formatPhoneNumber($target);

            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->url, [
                'target' => $target,
                'message' => $message,
                'url' => $imageUrl,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Pesan dengan gambar berhasil dikirim',
                    'data' => $response->json()
                ];
            } else {
                throw new \Exception('API Error: ' . $response->body());
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp Image Error', [
                'target' => $target,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengirim gambar: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Kirim pesan dengan dokumen/file
     */
    public function sendDocument($target, $message, $fileUrl, $filename)
    {
        try {
            $target = $this->formatPhoneNumber($target);

            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->url, [
                'target' => $target,
                'message' => $message,
                'url' => $fileUrl,
                'filename' => $filename,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Dokumen berhasil dikirim',
                    'data' => $response->json()
                ];
            } else {
                throw new \Exception('API Error: ' . $response->body());
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp Document Error', [
                'target' => $target,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengirim dokumen: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Kirim pesan ke multiple targets
     */
    public function sendBulkMessage($targets, $message)
    {
        $results = [];

        foreach ($targets as $target) {
            $result = $this->sendMessage($target, $message);
            $results[] = [
                'target' => $target,
                'result' => $result
            ];

            sleep(2);
        }

        return $results;
    }

    /**
     * Cek status device/akun WhatsApp
     */
    public function checkDevice()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/get-devices');

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            } else {
                throw new \Exception('API Error: ' . $response->body());
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Template pesan untuk supplier
     */
    public function sendSupplierNotification($supplier, $templateType = 'info')
    {
        $nama = $supplier->nama_supplier;
        $nib = $supplier->nib;
        $jenis = $supplier->jenisBarang->nama_jenis;
        $kategori = $supplier->jenisBarang->kategori->nama_kategori;
        $status = ucfirst($supplier->status);

        // Gunakan Heredoc untuk string yang lebih bersih
        switch ($templateType) {
            case 'info':
                $message = <<<MSG
Halo *{$nama}*! 👋

📄 *Informasi Supplier Anda:*
━━━━━━━━━━━━━━━━━━━━
📋 NIB: `{$nib}`
📦 Jenis Barang: *{$jenis}*
🏷️ Kategori: *{$kategori}*
📍 Status: *{$status}*
━━━━━━━━━━━━━━━━━━━━

Terima kasih atas kerjasamanya! 🙏

_Pesan otomatis dari Sistem Inventori Klinik_
MSG;
                break;

            case 'order':
                $message = <<<MSG
Halo *{$nama}*! 👋

🛒 *Permintaan Pemesanan Barang*
━━━━━━━━━━━━━━━━━━━━
📦 Jenis Barang: *{$jenis}*
🏷️ Kategori: *{$kategori}*
━━━━━━━━━━━━━━━━━━━━

Mohon konfirmasi ketersediaan dan harga terbaik. 💰

Terima kasih! 🙏
MSG;
                break;

            case 'payment':
                $message = <<<MSG
Halo *{$nama}*! 👋

💳 *Notifikasi Pembayaran*
━━━━━━━━━━━━━━━━━━━━
Pembayaran untuk invoice telah kami proses. ✅
Mohon dicek dan konfirmasi. 📲

Terima kasih! 🙏
MSG;
                break;

            case 'reminder':
                $message = <<<MSG
Halo *{$nama}*! 👋

⏰ *Pengingat Penting*
━━━━━━━━━━━━━━━━━━━━
📦 Jenis Barang: *{$jenis}*
━━━━━━━━━━━━━━━━━━━━

Mohon segera ditindaklanjuti. 🚀

Terima kasih atas perhatiannya! 🙏
MSG;
                break;

            default:
                $message = <<<MSG
Halo *{$nama}*! 👋

Terima kasih atas kerjasamanya! 🙏

_Pesan otomatis dari Sistem Inventori Klinik_
MSG;
                break;
        }

        return $this->sendMessage($supplier->kontak, $message);
    }
}
