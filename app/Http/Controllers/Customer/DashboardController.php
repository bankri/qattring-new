<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik Pesanan
        $totalPesanan = Pemesanan::where('id_pelanggan', $user->id)->count();

        $pesananSelesai = Pemesanan::where('id_pelanggan', $user->id)
            ->whereIn('status', ['completed', 'sent'])
            ->count();

        $pesananDiproses = Pemesanan::where('id_pelanggan', $user->id)
            ->whereIn('status', ['pending', 'waiting_payment', 'paid', 'in_progress'])
            ->count();

        // Total belanja (hanya yang completed)
        $totalBelanja = Pemesanan::where('id_pelanggan', $user->id)
            ->where('status', 'completed')
            ->sum('total_bayar');

        // Riwayat pesanan terbaru (5 terakhir)
        $riwayatPesanan = Pemesanan::where('id_pelanggan', $user->id)
            ->with(['detailPemesanans.paket', 'jenisPembayaran'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact(
            'totalPesanan',
            'pesananSelesai',
            'pesananDiproses',
            'totalBelanja',
            'riwayatPesanan'
        ));
    }
}
