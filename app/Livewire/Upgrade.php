<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Transaction; // <-- Pastikan ini sudah di-use
use App\Traits\MiniToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class Upgrade extends Component
{
    use MiniToast;
    public $user, $packages, $paketUser, $paket1, $paket2, $paket3;
    public string $snapToken;

    public function mount(): void
    {
        $this->packages = Package::all();
        foreach ($this->packages as $paket) {
            if ($paket->duration == 30) {
                $this->paket1 = $paket;
            }
            if ($paket->duration == 60) {
                $this->paket2 = $paket;
            }
            if ($paket->duration == 365) {
                $this->paket3 = $paket;
            }
        }
        $this->user = Auth::user();
    }

    public function pay($id): void
    {
        $this->paketUser = $this->packages->where('id', $id)->first();

        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = uniqid('INV-'); // Pindahkan ini ke sini agar bisa dipakai di transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $orderId, // Gunakan orderId yang sudah dibuat
                'gross_amount' => $this->paketUser->price,
            ],
            'customer_details' => [
                'first_name' => $this->user->name,
                'email' => $this->user->email,
            ],
            // --- TAMBAHKAN BAGIAN CALLBACKS INI ---
            'callbacks' => [
                // 'finish' => url('/transaksi/finish/' . $orderId), // Opsional
                // 'error' => url('/transaksi/error/' . $orderId),   // Opsional
                // 'pending' => url('/transaksi/pending/' . $orderId), // Opsional
                // 'notification' => url('https://98205558276a.ngrok-free.app/api/midtrans-webhook'), // <--- INI PENTING!
            ],
            // --- AKHIR TAMBAHAN ---
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Simpan transaksi pending di sini, setelah mendapatkan snapToken
            Transaction::create([
                'user_id' => $this->user->id,
                'package_id' => $this->paketUser->id,
                'package_name' => $this->paketUser->name, // Tambahkan ini agar tidak null
                'order_id' => $orderId, // Gunakan orderId yang sudah dibuat
                'status' => 'pending',
                'amount' => $this->paketUser->price,
                'snap_token' => $snapToken,
            ]);

            $this->snapToken = $snapToken;
            $this->dispatch('snap-token-received', token: $snapToken);
        } catch (\Exception $e) {
            $this->miniToast("Gagal membuat token pembayaran: " . $e->getMessage(), 'error');
            // Log the error for debugging
            Log::error("Failed to create Snap token in Upgrade component: " . $e->getMessage(), ['exception' => $e]);
        }
    }

    // Method handlePayment ini di Upgrade.php adalah duplikasi dan TIDAK DIGUNAKAN oleh Midtrans webhook.
    // Webhook akan langsung ke MidtransWebhookController.
    // Logic update status harus ada di MidtransWebhookController.
    // handlePayment di sini HANYA akan dipanggil oleh JavaScript `onSuccess`, `onPending`, `onError` dari Snap.
    // Ini bagus untuk update status real-time di browser, tapi BUKAN untuk reliable update status dari Midtrans.
    public function handlePayment($result): void
    {
        // PERHATIAN: Logika ini BUKAN dari webhook, tapi dari callback JavaScript Snap.
        // Webhook akan memanggil MidtransWebhookController secara terpisah.
        // Anda bisa menyederhanakan logic di sini atau membiarkannya sebagai update cepat.
        // Pastikan MidtransWebhookController adalah sumber kebenaran utama.

        $data = Transaction::where('order_id', $result['order_id'])->first(); // Cari transaksi yang sudah ada

        if (!$data) {
            // Jika transaksi belum disimpan (misal karena uncomment Transaction::create di atas)
            // Simpan transaksi baru jika belum ada
            $data = Transaction::create([
                'user_id' => $this->user->id,
                'package_id' => $this->paketUser->id,
                'package_name' => $this->paketUser->name,
                'order_id' => $result['order_id'],
                'amount' => $result['gross_amount'],
                'snap_token' => $this->snapToken, // Snap token dari sesi ini
            ]);
        }


        $data->update([ // Update statusnya
            'transaction_id' => $result['transaction_id'],
            'payment_type' => $result['payment_type'],
            'status' => $result['transaction_status'],
        ]);

        if ($data->status === 'settlement' || $data->status === 'capture') {
            $this->user->update([
                'account_type' => 'premium',
                'premium_until' => Carbon::now()->addDays((int) $data->package->duration),
            ]);
            $this->miniToast('Pembayaran berhasil.', redirectTo: '/auth/dashboard');
        } else {
            $this->miniToast('Lanjutkan pembayaran di menu transaksi', 'info', timeout: 3000, redirectTo: '/auth/transactions');
        }
    }

    public function render()
    {
        return view('livewire.upgrade', [
            'satuBulan' => $this->paket1,
            'duaBulan' => $this->paket2,
            'satuTahun' => $this->paket3
        ]);
    }
}
