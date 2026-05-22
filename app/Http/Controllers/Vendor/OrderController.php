<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Daftar pesanan untuk vendor
     */
    public function index()
    {
        $vendorId = Auth::id();

        $orders = Pemesanan::whereHas('detailPemesanans', function($query) use ($vendorId) {
                $query->where('id_vendor', $vendorId);
            })
            ->with(['pelanggan', 'detailPemesanans.paket'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('vendor.orders.index', compact('orders'));
    }

    /**
     * Detail pesanan
     */
    public function show(int $id)
    {
        /** @var \App\Models\Pemesanan $order */
        $order = Pemesanan::whereHas('detailPemesanans', function($query) {
                $query->where('id_vendor', Auth::id());
            })
            ->with(['pelanggan', 'detailPemesanans.paket', 'jenisPembayaran'])
            ->findOrFail($id);

        return view('vendor.orders.show', compact('order'));
    }

    /**
     * Terima pesanan (Vendor Confirm) - STATUS BERUBAH KE IN_PROGRESS
     */
    public function accept(Request $request, int $id)
{
    // AMBIL ORDER DARI DATABASE DULU!
    $order = Pemesanan::whereHas('detailPemesanans', function($query) {
            $query->where('id_vendor', Auth::id());
        })
        ->findOrFail($id);

    // Cek apakah bisa dikonfirmasi
    if ($order->status !== 'pending') {
        return redirect()->back()
            ->with('error', 'Pesanan sudah diproses sebelumnya');
    }

    $validated = $request->validate([
        'vendor_notes' => 'nullable|string|max:500',
    ]);

    // Update order
    $order->update([
        'status' => 'in_progress',
        'status_pesan' => 'Sedang Diproses',
        'vendor_notes' => $validated['vendor_notes'] ?? $order->vendor_notes,
        'confirmed_at' => now(),
    ]);

    return redirect()->route('vendor.orders.index')
        ->with('success', '✅ Pesanan diterima! Status berubah menjadi "Sedang Diproses".');
}

    /**
     * Tolak pesanan (Vendor Reject) - STATUS BERUBAH KE REJECTED/CANCELLED
     */
    public function reject(Request $request, int $id)
    {
        /** @var \App\Models\Pemesanan $order */
        $order = Pemesanan::whereHas('detailPemesanans', function($query) {
                $query->where('id_vendor', Auth::id());
            })
            ->findOrFail($id);

        if (!$order->canConfirmByVendor()) {
            return redirect()->back()
                ->with('error', 'Pesanan sudah diproses sebelumnya');
        }

        $validated = $request->validate([
            'rejected_reason' => 'required|string|max:255',
        ]);

        $order->update([
            'status' => 'rejected',
            'status_pesan' => 'Ditolak Vendor',
            'rejected_reason' => $validated['rejected_reason'],
            'confirmed_at' => now(),
        ]);

        return redirect()->route('vendor.orders.index')
            ->with('success', 'Pesanan ditolak. Customer akan mendapat notifikasi.');
    }

    /**
     * Mulai proses pesanan (Vendor Start Cooking)
     */
    public function startProcessing(int $id)
    {
        /** @var \App\Models\Pemesanan $order */
        $order = Pemesanan::whereHas('detailPemesanans', function($query) {
                $query->where('id_vendor', Auth::id());
            })
            ->findOrFail($id);

        if (!in_array($order->status, ['waiting_payment', 'paid', 'in_progress'])) {
            return redirect()->back()
                ->with('error', 'Pesanan belum bisa diproses');
        }

        $order->update([
            'status' => 'in_progress',
            'status_pesan' => 'Sedang Diproses',
        ]);

        return redirect()->route('vendor.orders.show', $id)
            ->with('success', 'Pesanan sedang diproses/dimasak');
    }

    /**
     * Kirim pesanan (Vendor Send) - STATUS BERUBAH KE SENT
     */
    public function send(Request $request, int $id)
    {
        /** @var \App\Models\Pemesanan $order */
        $order = Pemesanan::whereHas('detailPemesanans', function($query) {
                $query->where('id_vendor', Auth::id());
            })
            ->findOrFail($id);

        if (!$order->canSendByVendor()) {
            return redirect()->back()
                ->with('error', 'Pesanan belum selesai diproses');
        }

        $validated = $request->validate([
            'no_resi' => 'nullable|string|max:50',
        ]);

        $order->update([
            'status' => 'sent',
            'status_pesan' => 'Dikirim',
            'no_resi' => $validated['no_resi'] ?? null,
            'sent_at' => now(),
        ]);

        return redirect()->route('vendor.orders.index')
            ->with('success', '🚚 Pesanan sudah dikirim ke customer!');
    }

    /**
     * Update status pembayaran (untuk testing/manual)
     */
    public function markAsPaid(int $id)
    {
        /** @var \App\Models\Pemesanan $order */
        $order = Pemesanan::whereHas('detailPemesanans', function($query) {
                $query->where('id_vendor', Auth::id());
            })
            ->findOrFail($id);

        if ($order->status !== 'waiting_payment') {
            return redirect()->back()
                ->with('error', 'Pesanan belum menunggu pembayaran');
        }

        $order->update([
            'status' => 'paid',
            'status_pesan' => 'Sudah Dibayar',
            'paid_at' => now(),
        ]);

        return redirect()->route('vendor.orders.show', $id)
            ->with('success', 'Pembayaran dikonfirmasi');
    }

    /**
     * Helper: Cek apakah vendor bisa konfirmasi pesanan
     */
    private function canConfirmByVendor($order)
    {
        return $order->status === 'pending';
    }
}
