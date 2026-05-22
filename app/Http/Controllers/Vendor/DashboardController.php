<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik Paket
        $totalPaket = Paket::where('id_vendor', $user->id)->count();

        // Statistik Pesanan (hanya pesanan yang berisi paket dari vendor ini)
        $totalPesanan = Pemesanan::whereHas('detailPemesanans', function($q) use ($user) {
                $q->where('id_vendor', $user->id);
            })->count();

        // Hitung total pendapatan (hanya yang status completed/paid)
        $totalPendapatan = Pemesanan::whereHas('detailPemesanans', function($q) use ($user) {
                $q->where('id_vendor', $user->id);
            })
            ->whereIn('status', ['paid', 'completed', 'sent'])
            ->sum('total_bayar');

        // Pesanan Terbaru (5 terakhir)
        $pesananTerbaru = Pemesanan::whereHas('detailPemesanans', function($q) use ($user) {
                $q->where('id_vendor', $user->id);
            })
            ->with(['pelanggan', 'detailPemesanans.paket'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pesanan yang perlu dikonfirmasi (status pending)
        $pesananPending = Pemesanan::whereHas('detailPemesanans', function($q) use ($user) {
                $q->where('id_vendor', $user->id);
            })
            ->where('status', 'pending')
            ->count();

        // Paket terbaru
        $paketList = Paket::where('id_vendor', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('vendor.dashboard', compact(
            'totalPaket',
            'totalPesanan',
            'totalPendapatan',
            'pesananTerbaru',
            'pesananPending',
            'paketList'
        ));
    }
}
