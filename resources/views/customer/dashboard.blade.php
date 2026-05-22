@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="hero-gradient text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <p class="text-orange-100">Selamat datang, {{ auth()->user()->nama_pelanggan }}! 👋</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $totalPesanan }}</div>
                        <div class="text-gray-500 text-sm">Total Pesanan</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $pesananSelesai }}</div>
                        <div class="text-gray-500 text-sm">Selesai</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $pesananDiproses }}</div>
                        <div class="text-gray-500 text-sm">Diproses</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wallet text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</div>
                        <div class="text-gray-500 text-sm">Total Belanja</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order History -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-xl font-bold">Riwayat Pesanan</h3>
                    <a href="{{ route('customer.orders') }}" class="text-primary hover:underline">Lihat Semua</a>
                </div>
                <div>
                    @if($riwayatPesanan->count() > 0)
                        @foreach($riwayatPesanan as $order)
                        <div class="p-6 border-b last:border-b-0 hover:bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <div class="font-semibold text-lg">#ORD{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</div>
                                </div>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'waiting_payment' => 'bg-orange-100 text-orange-800',
                                        'paid' => 'bg-blue-100 text-blue-800',
                                        'in_progress' => 'bg-purple-100 text-purple-800',
                                        'sent' => 'bg-indigo-100 text-indigo-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-gray-100 text-gray-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu Konfirmasi',
                                        'waiting_payment' => 'Menunggu Pembayaran',
                                        'paid' => 'Sudah Dibayar',
                                        'in_progress' => 'Sedang Diproses',
                                        'sent' => 'Dikirim',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                        'rejected' => 'Ditolak',
                                    ];
                                @endphp
                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100' }}">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-3">
                                <div class="text-sm">
                                    <span class="text-gray-500">Tanggal Kirim:</span>
                                    <div class="font-medium">{{ \Carbon\Carbon::parse($order->tgl_pengiriman)->format('d M Y') }}</div>
                                </div>
                                <div class="text-sm">
                                    <span class="text-gray-500">Total:</span>
                                    <div class="font-semibold text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('customer.orders.show', $order->id) }}"
                                   class="bg-primary text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-700 transition">
                                    <i class="fas fa-eye mr-1"></i> Detail Pesanan
                                </a>
                                @if($order->status === 'pending')
                                <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan pesanan?')">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 transition">
                                        <i class="fas fa-times mr-1"></i> Batalkan
                                    </button>
                                </form>
                                @endif
                                @if($order->status === 'sent')
                                <form action="{{ route('customer.orders.confirm', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition">
                                        <i class="fas fa-check mr-1"></i> Pesanan Diterima
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-receipt text-4xl mb-3"></i>
                        <p class="mb-4">Belum ada pesanan</p>
                        <a href="{{ route('home') }}" class="text-primary font-medium">Mulai Belanja →</a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Profile & Quick Actions -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="text-center mb-4">
                        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user text-primary text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-lg">{{ auth()->user()->nama_pelanggan }}</h4>
                        <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="#" class="block w-full bg-gray-100 text-gray-700 text-center py-2 rounded-lg hover:bg-gray-200 transition">
                        Edit Profil
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h4 class="font-bold mb-4">Aksi Cepat</h4>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-utensils text-primary"></i>
                            <span>Lihat Paket</span>
                        </a>
                        <a href="{{ route('customer.cart') }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span>Keranjang</span>
                        </a>
                        <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-list text-primary"></i>
                            <span>Semua Pesanan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
