@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Pesanan</h1>
            <a href="{{ route('vendor.dashboard') }}" class="text-gray-600 hover:text-primary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            @if($orders->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kirim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="{{ $order->status === 'completed' ? 'bg-green-50' : ($order->status === 'pending' ? 'bg-yellow-50' : '') }}">
                        <td class="px-6 py-4 font-medium">#ORD{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">{{ $order->pelanggan->nama_pelanggan }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($order->tgl_pengiriman)->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-semibold">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            {!! $order->status_badge !!}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('vendor.orders.show', $order->id) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($orders->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $orders->links() }}
            </div>
            @endif
            @else
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p>Belum ada pesanan</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
