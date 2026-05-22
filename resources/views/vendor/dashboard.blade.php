@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-600 to-orange-500 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold">Dashboard Vendor</h1>
            <p class="text-orange-100">Kelola paket catering dan pesanan Anda</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $totalPaket ?? 0 }}</div>
                        <div class="text-gray-500 text-sm">Total Paket</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $totalPesanan ?? 0 }}</div>
                        <div class="text-gray-500 text-sm">Total Pesanan</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $pesananPending ?? 0 }}</div>
                        <div class="text-gray-500 text-sm">Menunggu Konfirmasi</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wallet text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</div>
                        <div class="text-gray-500 text-sm">Total Pendapatan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions - FITUR PENTING -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h3 class="text-xl font-bold mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('vendor.paket.create') }}"
                   class="bg-orange-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-orange-700 transition flex items-center justify-center gap-3">
                    <i class="fas fa-plus-circle text-xl"></i>
                    <div>
                        <div class="font-bold">Tambah Paket</div>
                        <div class="text-sm text-orange-100">Tambah menu catering baru</div>
                    </div>
                </a>

                <a href="{{ route('vendor.paket.index') }}"
                   class="bg-blue-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-3">
                    <i class="fas fa-utensils text-xl"></i>
                    <div>
                        <div class="font-bold">Kelola Paket</div>
                        <div class="text-sm text-blue-100">Edit/hapus menu</div>
                    </div>
                </a>

                <a href="{{ route('vendor.orders.index') }}"
                   class="bg-green-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-green-700 transition flex items-center justify-center gap-3">
                    <i class="fas fa-clipboard-list text-xl"></i>
                    <div>
                        <div class="font-bold">Kelola Pesanan</div>
                        <div class="text-sm text-green-100">Lihat & proses pesanan</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Packages -->
        <div class="bg-white rounded-xl shadow mb-8">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-xl font-bold">Paket Terbaru</h3>
                <a href="{{ route('vendor.paket.index') }}" class="text-orange-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                @if(isset($paketList) && $paketList->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Paket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($paketList as $paket)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $paket->nama_paket }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $paket->jenis == 'Prasmanan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $paket->jenis }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('vendor.paket.edit', $paket->id) }}"
                                   class="text-blue-600 hover:text-blue-800 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('vendor.paket.destroy', $paket->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus paket ini?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-box-open text-4xl mb-3"></i>
                    <p>Belum ada paket. <a href="{{ route('vendor.paket.create') }}" class="text-orange-600 font-medium">Tambahkan sekarang</a></p>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-xl font-bold">Pesanan Terbaru</h3>
                <a href="{{ route('vendor.orders.index') }}" class="text-orange-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                @if(isset($pesananTerbaru) && $pesananTerbaru->count() > 0)
                <table class="w-full">
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
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pesananTerbaru as $order)
                        <tr>
                            <td class="px-6 py-4 font-medium">#ORD{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">{{ $order->pelanggan->nama_pelanggan }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($order->tgl_pengiriman)->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-semibold">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'waiting_payment' => 'bg-orange-100 text-orange-800',
                                        'paid' => 'bg-blue-100 text-blue-800',
                                        'in_progress' => 'bg-purple-100 text-purple-800',
                                        'sent' => 'bg-indigo-100 text-indigo-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu Konfirmasi',
                                        'waiting_payment' => 'Menunggu Pembayaran',
                                        'paid' => 'Sudah Dibayar',
                                        'in_progress' => 'Sedang Diproses',
                                        'sent' => 'Dikirim',
                                        'completed' => 'Selesai',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100' }}">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('vendor.orders.show', $order->id) }}"
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p>Belum ada pesanan</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
