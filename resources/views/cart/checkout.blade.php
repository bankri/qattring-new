@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        <form action="{{ route('customer.order.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Shipping Info -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        Alamat Pengiriman
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
                            <input type="text" name="nama_penerima" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                   value="{{ auth()->user()->nama_pelanggan ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="tel" name="telepon" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                   value="{{ auth()->user()->telepon ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">{{ auth()->user()->alamat1 ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu Pengiriman</label>
                            <input type="datetime-local" name="tgl_pengiriman" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-credit-card text-primary"></i>
                        Metode Pembayaran
                    </h3>

                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-primary transition">
                            <input type="radio" name="payment_method" value="transfer" checked class="mr-3">
                            <div>
                                <div class="font-semibold">Transfer Bank</div>
                                <div class="text-sm text-gray-500">BCA, Mandiri, BNI, BRI</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-primary transition">
                            <input type="radio" name="payment_method" value="cod" class="mr-3">
                            <div>
                                <div class="font-semibold">Cash on Delivery (COD)</div>
                                <div class="text-sm text-gray-500">Bayar saat pesanan tiba</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-primary transition">
                            <input type="radio" name="payment_method" value="ewallet" class="mr-3">
                            <div>
                                <div class="font-semibold">E-Wallet</div>
                                <div class="text-sm text-gray-500">GoPay, OVO, DANA</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-xl font-bold mb-4">Ringkasan Pesanan</h3>

                <div class="space-y-3 mb-6">
                    @foreach(session('cart') as $item)
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="font-medium">{{ $item['name'] }}</span>
                            <span class="text-gray-500 text-sm">x{{ $item['quantity'] }}</span>
                        </div>
                        <span class="font-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span>Rp {{ number_format(array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], session('cart'))), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkir</span>
                        <span class="text-green-600">Gratis</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-2 border-t">
                        <span>Total</span>
                        <span class="text-primary">Rp {{ number_format(array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], session('cart'))), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between">
                <a href="{{ route('customer.cart') }}" class="text-gray-600 hover:text-primary">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Keranjang
                </a>
                <button type="submit"
                        class="bg-primary text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-orange-700 transition transform hover:scale-105">
                    <i class="fas fa-check mr-2"></i>
                    Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
