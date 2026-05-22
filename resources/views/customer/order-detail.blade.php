@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('customer.orders') }}" class="text-gray-600 hover:text-primary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Riwayat Pesanan
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Order Status Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-2xl font-bold">Pesanan #ORD{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-gray-500">Dibuat: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    {!! $order->status_badge !!}
                </div>
            </div>

            <!-- Progress Status -->
            <div class="mt-6">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col items-center {{ in_array($order->status, ['pending', 'in_progress', 'sent', 'completed']) ? 'text-green-600' : 'text-gray-400' }}">
                        <div class="w-12 h-12 rounded-full bg-current bg-opacity-20 flex items-center justify-center mb-2">
                            <i class="fas fa-clipboard-list text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold">Pesanan Dibuat</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-300 mx-2">
                        <div class="h-full {{ in_array($order->status, ['in_progress', 'sent', 'completed']) ? 'bg-green-600' : 'bg-gray-300' }}"></div>
                    </div>
                    <div class="flex flex-col items-center {{ in_array($order->status, ['in_progress', 'sent', 'completed']) ? 'text-green-600' : 'text-gray-400' }}">
                        <div class="w-12 h-12 rounded-full bg-current bg-opacity-20 flex items-center justify-center mb-2">
                            <i class="fas fa-check text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold">Dikonfirmasi</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-300 mx-2">
                        <div class="h-full {{ in_array($order->status, ['sent', 'completed']) ? 'bg-green-600' : 'bg-gray-300' }}"></div>
                    </div>
                    <div class="flex flex-col items-center {{ in_array($order->status, ['sent', 'completed']) ? 'text-green-600' : 'text-gray-400' }}">
                        <div class="w-12 h-12 rounded-full bg-current bg-opacity-20 flex items-center justify-center mb-2">
                            <i class="fas fa-shipping-fast text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold">Dikirim</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-300 mx-2">
                        <div class="h-full {{ $order->status === 'completed' ? 'bg-green-600' : 'bg-gray-300' }}"></div>
                    </div>
                    <div class="flex flex-col items-center {{ $order->status === 'completed' ? 'text-green-600' : 'text-gray-400' }}">
                        <div class="w-12 h-12 rounded-full bg-current bg-opacity-20 flex items-center justify-center mb-2">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold">Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informasi Pesanan -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold mb-4">Informasi Pesanan</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-500 text-sm">Tanggal Pengiriman:</span>
                        <div class="font-semibold">{{ \Carbon\Carbon::parse($order->tgl_pengiriman)->format('d M Y, H:i') }}</div>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Metode Pembayaran:</span>
                        <div class="font-semibold">{{ $order->jenisPembayaran->metode_pembayaran ?? '-' }}</div>
                    </div>
                    @if($order->no_resi)
                    <div>
                        <span class="text-gray-500 text-sm">No. Resi:</span>
                        <div class="font-semibold">{{ $order->no_resi }}</div>
                    </div>
                    @endif
                    @if($order->vendor_notes)
                    <div>
                        <span class="text-gray-500 text-sm">Catatan:</span>
                        <div class="text-sm">{{ $order->vendor_notes }}</div>
                    </div>
                    @endif
                    @if($order->rejected_reason)
                    <div class="bg-red-50 p-3 rounded-lg">
                        <span class="text-red-600 text-sm font-semibold">Alasan Penolakan:</span>
                        <div class="text-red-700 text-sm">{{ $order->rejected_reason }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Total Pembayaran -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold mb-4">Total Pembayaran</h3>
                <div class="text-3xl font-bold text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</div>
                <p class="text-sm text-gray-500 mt-2">Termasuk ongkos kirim (Gratis)</p>
            </div>
        </div>

        <!-- Daftar Paket -->
        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h3 class="text-lg font-bold mb-4">Daftar Paket</h3>
            <div class="space-y-3">
                @foreach($order->detailPemesanans as $detail)
                <div class="flex items-center gap-4 p-4 border rounded-lg">
                    @if($detail->paket && $detail->paket->foto1)
                        <img src="{{ asset('storage/' . $detail->paket->foto1) }}"
                             alt="{{ $detail->paket->nama_paket }}"
                             class="w-20 h-20 object-cover rounded-lg">
                    @else
                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                        </div>
                    @endif
                    <div class="flex-1">
                        <div class="font-semibold">{{ $detail->paket->nama_paket ?? 'Paket tidak tersedia' }}</div>
                        <div class="text-sm text-gray-500">{{ $detail->paket->jenis ?? '-' }} | {{ $detail->paket->kategori ?? '-' }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-primary">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex gap-4">
            @if($order->status === 'pending')
                <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin membatalkan pesanan?')"
                      class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-600 transition">
                        <i class="fas fa-times mr-2"></i> Batalkan Pesanan
                    </button>
                </form>
            @endif

            @if($order->status === 'sent')
                <form action="{{ route('customer.orders.confirm', $order->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition">
                        <i class="fas fa-check-circle mr-2"></i> Pesanan Diterima
                    </button>
                </form>
            @endif

            @if($order->status === 'completed')
                <div class="bg-green-100 text-green-800 px-6 py-3 rounded-lg font-semibold">
                    <i class="fas fa-check-circle mr-2"></i> Pesanan Selesai
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
