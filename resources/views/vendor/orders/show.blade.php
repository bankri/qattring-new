@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('vendor.orders.index') }}" class="text-gray-600 hover:text-primary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Pesanan
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Order Status -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-2xl font-bold">Pesanan #ORD{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-gray-500">Dari: {{ $order->pelanggan->nama_pelanggan }}</p>
                </div>
                <div>
                    {!! $order->status_badge !!}
                </div>
            </div>

            <!-- Color Indicator -->
            <div class="mt-4 p-4 rounded-lg {{
                $order->status === 'completed' ? 'bg-green-100 border-l-4 border-green-500' :
                ($order->status === 'pending' ? 'bg-yellow-100 border-l-4 border-yellow-500' :
                ($order->status === 'in_progress' ? 'bg-purple-100 border-l-4 border-purple-500' :
                ($order->status === 'sent' ? 'bg-indigo-100 border-l-4 border-indigo-500' :
                ($order->status === 'rejected' || $order->status === 'cancelled' ? 'bg-red-100 border-l-4 border-red-500' : 'bg-blue-100 border-l-4 border-blue-500'))))
            }}">
                <div class="flex items-center gap-3">
                    @if($order->status === 'completed')
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        <div>
                            <div class="font-bold text-green-800">Pesanan Selesai</div>
                            <div class="text-sm text-green-700">Customer telah menerima pesanan</div>
                        </div>
                    @elseif($order->status === 'pending')
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                        <div>
                            <div class="font-bold text-yellow-800">Menunggu Konfirmasi</div>
                            <div class="text-sm text-yellow-700">Silakan konfirmasi atau tolak pesanan</div>
                        </div>
                    @elseif($order->status === 'in_progress')
                        <i class="fas fa-fire text-purple-600 text-2xl"></i>
                        <div>
                            <div class="font-bold text-purple-800">Sedang Diproses</div>
                            <div class="text-sm text-purple-700">Pesanan sedang dimasak/disiapkan</div>
                        </div>
                    @elseif($order->status === 'sent')
                        <i class="fas fa-shipping-fast text-indigo-600 text-2xl"></i>
                        <div>
                            <div class="font-bold text-indigo-800">Dikirim</div>
                            <div class="text-sm text-indigo-700">Pesanan dalam perjalanan ke customer</div>
                        </div>
                    @else
                        <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                        <div>
                            <div class="font-bold text-blue-800">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold mb-4">Informasi Customer</h3>
                <div class="space-y-2">
                    <div>
                        <span class="text-gray-500 text-sm">Nama:</span>
                        <div class="font-semibold">{{ $order->pelanggan->nama_pelanggan }}</div>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Email:</span>
                        <div class="font-semibold">{{ $order->pelanggan->email }}</div>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Telepon:</span>
                        <div class="font-semibold">{{ $order->pelanggan->telepon ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Delivery Info -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold mb-4">Informasi Pengiriman</h3>
                <div class="space-y-2">
                    <div>
                        <span class="text-gray-500 text-sm">Tanggal Kirim:</span>
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
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
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
                        @if($detail->paket && $detail->paket->deskripsi)
                        <div class="text-sm text-gray-600 mt-1">{{ Str::limit($detail->paket->deskripsi, 100) }}</div>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-primary">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold">Total Pembayaran:</span>
                    <span class="text-2xl font-bold text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons Based on Status -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold mb-4">Aksi</h3>

            @if($order->status === 'pending')
                <!-- Vendor Accept/Reject -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Accept Form -->
                    <form action="{{ route('vendor.orders.accept', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan untuk Customer (Opsional)</label>
                            <textarea name="vendor_notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" placeholder="Contoh: Pesanan akan kami proses, terima kasih!">{{ old('vendor_notes', $order->vendor_notes) }}</textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition">
                            <i class="fas fa-check-circle mr-2"></i> Terima Pesanan
                        </button>
                    </form>

                    <!-- Reject Form -->
                    <form action="{{ route('vendor.orders.reject', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan *</label>
                            <textarea name="rejected_reason" rows="2" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" placeholder="Contoh: Maaf kak, stok sedang habis&#10;Maaf kak, toko kami sedang tutup"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-red-500 text-white py-3 rounded-lg font-semibold hover:bg-red-600 transition">
                            <i class="fas fa-times-circle mr-2"></i> Tolak Pesanan
                        </button>
                    </form>
                </div>

            @elseif($order->status === 'in_progress')
                <!-- Mark as Sent -->
                <form action="{{ route('vendor.orders.send', $order->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Resi (Opsional)</label>
                        <input type="text" name="no_resi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" placeholder="Masukkan nomor resi pengiriman">
                    </div>
                    <button type="submit" class="w-full bg-indigo-500 text-white py-3 rounded-lg font-semibold hover:bg-indigo-600 transition">
                        <i class="fas fa-shipping-fast mr-2"></i> Tandai Sudah Dikirim
                    </button>
                </form>

            @elseif($order->status === 'sent')
                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-info-circle text-indigo-600 text-xl"></i>
                        <div>
                            <div class="font-semibold text-indigo-800">Pesanan Sedang Dikirim</div>
                            <div class="text-sm text-indigo-700">Menunggu konfirmasi penerimaan dari customer</div>
                        </div>
                    </div>
                </div>

            @elseif($order->status === 'completed')
                <div class="bg-green-50 border-l-4 border-green-500 p-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        <div>
                            <div class="font-semibold text-green-800">Pesanan Selesai</div>
                            <div class="text-sm text-green-700">Customer telah menerima pesanan pada {{ \Carbon\Carbon::parse($order->completed_at)->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>

            @elseif($order->status === 'rejected' || $order->status === 'cancelled')
                <div class="bg-red-50 border-l-4 border-red-500 p-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        <div>
                            <div class="font-semibold text-red-800">Pesanan Dibatalkan</div>
                            <div class="text-sm text-red-700">{{ $order->rejected_reason ?: 'Pesanan dibatalkan' }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
