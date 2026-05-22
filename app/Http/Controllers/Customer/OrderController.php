<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\Paket;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Checkout page
     */
    public function checkout()
    {
        /** @var \App\Models\Pelanggan $user */
        $user = auth()->user();

        if ($user && $user->role === 'vendor') {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Vendor tidak memiliki akses ke checkout');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang masih kosong');
        }

        // Hitung total
        $total = array_sum(array_map(fn($item) => $item['subtotal'], $cart));

        // Ambil metode pembayaran
        $paymentMethods = JenisPembayaran::all();

        return view('customer.checkout', compact('cart', 'total', 'paymentMethods'));
    }

    /**
     * Proses pesanan (Create Order) - DIPICU OLEH TOMBOL "PESAN SEKARANG"
     */
    public function store(Request $request)
    {
       try {
        \Log::info('=== ORDER STORE CALLED ===');

        // Validasi - SESUAIKAN DENGAN NAMA FIELD DI FORM
        $validated = $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:500',  // UBAH: alamat_pengiriman -> alamat
            'tgl_pengiriman' => 'required|date|after:today',
            'payment_method' => 'required',  // UBAH: id_jenis_bayar -> payment_method
        ], [
            'nama_penerima.required' => 'Nama penerima wajib diisi',
            'telepon.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'tgl_pengiriman.required' => 'Tanggal pengiriman wajib diisi',
            'tgl_pengiriman.after' => 'Tanggal pengiriman minimal besok',
            'payment_method.required' => 'Metode pembayaran wajib dipilih',
        ]);

        \Log::info('Validated data: ', $validated);

        $cart = session()->get('cart', []);

        \Log::info('Cart data: ', $cart);

        if (empty($cart)) {
            \Log::error('Cart is empty!');
            return redirect()->route('customer.cart')->with('error', 'Keranjang masih kosong');
        }

        DB::beginTransaction();

        try {
            // Hitung total
            $total = array_sum(array_map(fn($item) => $item['subtotal'], $cart));
            \Log::info('Total: ' . $total);

            // Ambil id_jenis_bayar dari payment_method
            // Kalau payment_method = "transfer", maka id = 1 (contoh)
            $idJenisBayar = 1; // Default
            if ($validated['payment_method'] == 'transfer') {
                $idJenisBayar = 1;
            } elseif ($validated['payment_method'] == 'cod') {
                $idJenisBayar = 2;
            } elseif ($validated['payment_method'] == 'ewallet') {
                $idJenisBayar = 3;
            }

            // Buat pesanan
$pemesanan = Pemesanan::create([
    'id_pelanggan' => auth()->id(),
    'id_jenis_bayar' => $idJenisBayar,
    'tgl_pesan' => now(),
    'tgl_pengiriman' => $validated['tgl_pengiriman'],
    'status' => 'pending',
    'status_pesan' => 'Menunggu Konfirmasi',  // UBAH: Lebih pendek!
    'total_bayar' => $total,
    'vendor_notes' => $validated['catatan'] ?? null,
]);

            \Log::info('Order created with ID: ' . $pemesanan->id);

            // Simpan detail pesanan
            foreach ($cart as $id => $item) {
                $paket = Paket::where('nama_paket', $item['name'])->first();

                if ($paket) {
                    DetailPemesanan::create([
                        'id_pemesanan' => $pemesanan->id,
                        'id_paket' => $paket->id,
                        'id_vendor' => $paket->id_vendor,
                        'subtotal' => $item['subtotal'],
                    ]);
                    \Log::info('Detail created for paket: ' . $paket->nama_paket);
                } else {
                    \Log::error('Paket not found: ' . $item['name']);
                }
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            \Log::info('Order success! Redirecting...');

            return redirect()->route('customer.orders.show', $pemesanan->id)
                ->with('success', '🎉 Pesanan berhasil dibuat! Menunggu konfirmasi vendor.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Database error: ' . $e->getMessage());
            throw $e;
        }

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation error: ', $e->errors());
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput();
    } catch (\Exception $e) {
        \Log::error('General error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
    }

    /**
     * Detail pesanan customer
     */
    public function show(int $id)
    {
        /** @var \App\Models\Pelanggan $user */
        $user = auth()->user();

        /** @var \App\Models\Pemesanan $order */
        $order = Pemesanan::where('id', $id)
            ->where('id_pelanggan', $user->id)
            ->with(['detailPemesanans.paket', 'jenisPembayaran'])
            ->firstOrFail();

        return view('customer.order-detail', compact('order'));
    }

    /**
     * Daftar pesanan customer
     */
    public function index()
    {
        /** @var \App\Models\Pelanggan $user */
        $user = auth()->user();

        $orders = Pemesanan::where('id_pelanggan', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    /**
     * Batalkan pesanan (oleh customer)
     */
    public function cancel(int $id)
    {
        /** @var \App\Models\Pelanggan $user */
        $user = auth()->user();

        /** @var \App\Models\Pemesanan $order */
        $order = Pemesanan::where('id', $id)
            ->where('id_pelanggan', $user->id)
            ->firstOrFail();

        if (!$order->canCancelByCustomer()) {
            return redirect()->back()
                ->with('error', 'Pesanan tidak bisa dibatalkan karena sudah diproses vendor');
        }

        $order->update([
            'status' => 'cancelled',
            'status_pesan' => 'Dibatalkan Customer',
        ]);

        return redirect()->route('customer.orders')
            ->with('success', 'Pesanan berhasil dibatalkan');
    }

    /**
     * Konfirmasi pesanan diterima (oleh customer) - PESANAN SELESAI
     */
    public function confirmReceived(int $id)
{
    // AMBIL DATA ORDER DARI DATABASE DULU!
    $order = Pemesanan::where('id', $id)
        ->where('id_pelanggan', auth()->id()) // Pastikan milik customer yang login
        ->firstOrFail();

    // Cek apakah statusnya sudah 'sent' (Dikirim)
    if ($order->status !== 'sent') {
        return redirect()->back()
            ->with('error', 'Pesanan belum dikirim, tidak bisa dikonfirmasi.');
    }

    // Update status ke 'completed' (Selesai)
    $order->update([
        'status' => 'completed',
        'status_pesan' => 'Selesai',
        'completed_at' => now(),
    ]);

    return redirect()->route('customer.orders.show', $id)
        ->with('success', '✅ Terima kasih! Pesanan sudah diterima dan selesai.');
}


}
