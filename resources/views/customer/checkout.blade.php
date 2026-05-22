@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('customer.order.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @csrf

            <!-- Kolom Kiri: Informasi Pengiriman -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        Alamat Pengiriman
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima *</label>
                            <input type="text" name="nama_penerima" required
                                   value="{{ old('nama_penerima', auth()->user()->nama_pelanggan) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon *</label>
                            <input type="text" name="telepon" required
                                   value="{{ old('telepon', auth()->user()->telepon) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                   placeholder="081234567890">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                            <textarea name="alamat_pengiriman" rows="3" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                      placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan">{{ old('alamat_pengiriman') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu Pengiriman *</label>
                            <input type="datetime-local" name="tgl_pengiriman" required
                                   min="{{ date('Y-m-d\TH:i', strtotime('tomorrow')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                            <p class="text-xs text-gray-500 mt-1">Minimal pemesanan H-1</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan untuk Vendor</label>
                            <textarea name="catatan" rows="2"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                      placeholder="Contoh: Jangan terlalu pedas, ada alergi seafood, dll...">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Metode Pembayaran & Ringkasan -->
            <div class="space-y-6">
                <!-- Metode Pembayaran -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-credit-card text-primary"></i>
                        Metode Pembayaran
                    </h3>

                    <div class="space-y-3">
                        @foreach($paymentMethods as $method)
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="id_jenis_bayar" value="{{ $method->id }}"
                                   {{ old('id_jenis_bayar') == $method->id ? 'checked' : ($loop->first ? 'checked' : '') }}
                                   class="text-primary focus:ring-primary">
                            <div class="ml-3">
                                <div class="font-semibold">{{ $method->metode_pembayaran }}</div>
                                @if($method->id == 1)
                                    <div class="text-sm text-gray-500">BCA, Mandiri, BNI, BRI</div>
                                @elseif($method->id == 2)
                                    <div class="text-sm text-gray-500">Bayar saat pesanan tiba</div>
                                @elseif($method->id == 3)
                                    <div class="text-sm text-gray-500">GoPay, OVO, DANA</div>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Ringkasan Pesanan</h3>

                    <div class="space-y-3 mb-4">
                        @foreach($cart as $id => $item)
                        <div class="flex justify-between items-center py-2 border-b">
                            <div>
                                <div class="font-medium">{{ $item['name'] }}</div>
                                <div class="text-sm text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                            <div class="font-semibold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkir</span>
                            <span class="text-green-600">Gratis</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t">
                            <span>Total</span>
                            <span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-primary text-white py-4 rounded-lg font-bold text-lg hover:bg-orange-700 transition flex items-center justify-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        Pesan Sekarang
                    </button>

                    <a href="{{ route('customer.cart') }}" class="block text-center mt-3 text-gray-600 hover:text-primary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
