@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

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

        @if(session('cart') && count(session('cart')) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach(session('cart') as $id => $item)
                <div class="bg-white rounded-xl shadow p-6 flex gap-4">
                    @if($item['image'])
                        <img src="{{ asset('storage/' . $item['image']) }}"
                             alt="{{ $item['name'] }}"
                             class="w-24 h-24 object-cover rounded-lg">
                    @else
                        <img src="https://via.placeholder.com/100?text=No+Image"
                             alt="{{ $item['name'] }}"
                             class="w-24 h-24 object-cover rounded-lg">
                    @endif

                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">{{ $item['name'] }}</h3>
                        <p class="text-primary font-bold mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>

                        <div class="flex items-center gap-4 mt-3">
                            <form action="{{ route('customer.cart.update', $id) }}" method="POST" class="flex items-center border rounded-lg">
                                @csrf
                                <button type="button" onclick="updateQty('{{ $id }}', -1)"
                                        class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-lg">-</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                       class="w-16 text-center border-0 focus:ring-0"
                                       onchange="this.form.submit()" id="qty-{{ $id }}">
                                <button type="button" onclick="updateQty('{{ $id }}', 1)"
                                        class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-lg">+</button>
                            </form>

                            <form action="{{ route('customer.cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="font-bold text-lg">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-4">Ringkasan Pesanan</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">Rp {{ number_format(array_sum(array_map(fn($i) => $i['subtotal'], session('cart'))), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkir</span>
                            <span class="font-semibold text-green-600">Gratis</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between text-lg">
                            <span class="font-bold">Total</span>
                            <span class="font-bold text-primary">Rp {{ number_format(array_sum(array_map(fn($i) => $i['subtotal'], session('cart'))), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('customer.checkout') }}"
                       class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-orange-700 transition text-center block">
                        Lanjutkan ke Checkout
                    </a>

                    <a href="{{ route('home') }}"
                       class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition text-center block mt-3">
                        Lanjutkan Belanja
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Keranjang masih kosong</h3>
            <p class="text-gray-500 mb-6">Yuk, pilih paket catering untuk acara Anda!</p>
            <a href="{{ route('home') }}" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                Lihat Paket
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function updateQty(id, change) {
        const input = document.getElementById(`qty-${id}`);
        let value = parseInt(input.value) + change;
        if (value < 1) value = 1;
        input.value = value;
        input.closest('form').submit();
    }
</script>
@endpush
@endsection
