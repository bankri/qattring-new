@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Beranda</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('home') }}#paket" class="hover:text-primary">Paket</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-primary font-medium">{{ $paket->nama_paket }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <!-- Image Gallery -->
                <!-- Image Gallery -->
<div class="space-y-4">
    <div class="aspect-w-16 aspect-h-12 rounded-xl overflow-hidden bg-gray-100">
        @if($paket->foto1)
            <img src="{{ asset('storage/' . $paket->foto1) }}"
                 alt="{{ $paket->nama_paket }}"
                 class="w-full h-80 object-cover rounded-xl" id="mainImage">
        @else
            <img src="https://via.placeholder.com/600x400?text={{ urlencode($paket->nama_paket) }}"
                 alt="{{ $paket->nama_paket }}"
                 class="w-full h-80 object-cover rounded-xl" id="mainImage">
        @endif
    </div>
    <div class="flex space-x-3">
        @php $fotos = [$paket->foto1, $paket->foto2, $paket->foto3]; @endphp
        @foreach($fotos as $foto)
            @if($foto)
                <button onclick="changeImage('{{ asset('storage/' . $foto) }}')"
                        class="w-20 h-20 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary transition">
                    <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover">
                </button>
            @endif
        @endforeach
    </div>
</div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-orange-100 text-primary px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $paket->jenis }}
                            </span>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                {{ $paket->kategori }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $paket->nama_paket }}</h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-gray-500">(128 ulasan)</span>
                    </div>

                    <p class="text-gray-600 leading-relaxed">{{ $paket->deskripsi }}</p>

                    <!-- Specs -->
                    <div class="grid grid-cols-2 gap-4 py-4 border-y">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-users text-primary text-xl"></i>
                            <div>
                                <div class="text-sm text-gray-500">Kapasitas</div>
                                <div class="font-semibold">{{ $paket->jumlah_pax }} Pax</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-utensils text-primary text-xl"></i>
                            <div>
                                <div class="text-sm text-gray-500">Jenis</div>
                                <div class="font-semibold">{{ $paket->jenis }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Add to Cart -->
                    <div class="space-y-4">
                        <div>
                            <span class="text-4xl font-bold text-primary">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</span>
                            <span class="text-gray-500">/paket</span>
                        </div>

                        <form action="{{ route('customer.cart.add', $paket->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex items-center gap-4">
                                <label class="text-gray-700 font-medium">Jumlah:</label>
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button" onclick="updateQty(-1)"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-l-lg">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1"
                                           class="w-16 text-center border-0 focus:ring-0">
                                    <button type="button" onclick="updateQty(1)"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-r-lg">+</button>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full bg-primary text-white py-4 rounded-xl font-semibold text-lg hover:bg-orange-700 transition transform hover:scale-105 flex items-center justify-center gap-2">
                                <i class="fas fa-shopping-cart"></i>
                                Tambahkan ke Keranjang
                            </button>
                        </form>

                        <button class="w-full bg-red-500 text-white py-3 rounded-xl font-semibold hover:bg-red-600 transition flex items-center justify-center gap-2">
                            <i class="fab fa-whatsapp"></i>
                            Pesan via WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Included Section -->
        <div class="mt-12 bg-white rounded-2xl shadow-xl p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Yang Termasuk dalam Paket</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <span>Nasi Putih / Nasi Goreng</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <span>Lauk Utama (Ayam/Sapi)</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <span>Lauk Pendamping</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <span>Sayur & Sambal</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <span>Buah & Dessert</span>
                </div>
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <span>Perlengkapan Makan</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }

    function updateQty(change) {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value) + change;
        if (value < 1) value = 1;
        input.value = value;
    }
</script>
@endpush
@endsection
