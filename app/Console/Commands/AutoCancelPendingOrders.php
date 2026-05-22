<?php

namespace App\Console\Commands;

use App\Models\Pemesanan;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AutoCancelPendingOrders extends Command
{
    /**
     * Nama perintah yang akan dipanggil di terminal
     */
    protected $signature = 'orders:auto-cancel';

    /**
     * Deskripsi perintah
     */
    protected $description = 'Otomatis batalkan pesanan pending yang lebih dari 2 jam';

    /**
     * Jalankan perintah
     */
    public function handle()
    {
        // Hitung waktu 2 jam yang lalu
        $twoHoursAgo = Carbon::now()->subHours(2);

        // Cari pesanan yang statusnya 'pending' dan dibuat lebih dari 2 jam lalu
        $cancelledCount = Pemesanan::where('status', 'pending')
            ->where('created_at', '<', $twoHoursAgo)
            ->update([
                'status' => 'cancelled',
                'status_pesan' => 'Auto Cancel - Vendor tidak konfirmasi dalam 2 jam',
            ]);

        // Tampilkan hasil di terminal
        if ($cancelledCount > 0) {
            $this->info("✅ Berhasil membatalkan {$cancelledCount} pesanan yang pending lebih dari 2 jam.");
        } else {
            $this->info("ℹ️ Tidak ada pesanan pending yang perlu dibatalkan saat ini.");
        }

        return 0;
    }
}
