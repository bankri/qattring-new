@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-primary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-8">Riwayat Pesanan</h1>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pesan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kirim</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="{{ $order->status === 'completed' ? 'bg-green-50' : ($order->status === 'pending' ? 'bg-yellow-50' : ($order->status === 'in_progress' ? 'bg-purple-50' : ($order->status === 'sent' ? 'bg-indigo-50' : ''))) }}">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                #ORD{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                {{ \Carbon\Carbon::parse($order->tgl_pengiriman)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-primary">
                                Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100' }}">
                                    {{ $statusLabels[$order->status] ?? $order->status_pesan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('customer.orders.show', $order->id) }}"
                                   class="text-blue-600 hover:text-blue-800 mr-3">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                                @if($order->status === 'pending')
                                <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan?')">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-times mr-1"></i> Batal
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
            @endif
            @else
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-receipt text-4xl mb-3"></i>
                <p class="text-lg mb-4">Belum ada pesanan</p>
                <a href="{{ route('home') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                    <i class="fas fa-shopping-cart mr-2"></i> Mulai Belanja
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
