@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">
                    Catering Terbaik untuk Acara Anda
                </h1>
                <p class="text-xl text-orange-100">
                    Nikmati hidangan lezat dan berkualitas untuk pernikahan, rapat, ulang tahun, dan acara spesial lainnya.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#paket" class="bg-white text-primary px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition transform hover:scale-105 text-center">
                        Lihat Paket
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="bg-green-500 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-green-600 transition transform hover:scale-105 text-center">
                        <i class="fab fa-whatsapp mr-2"></i>Hubungi Kami
                    </a>
                </div>
                <div class="flex items-center space-x-8 pt-4">
                    <div>
                        <div class="text-3xl font-bold">1000+</div>
                        <div class="text-orange-100">Pelanggan Puas</div>
                    </div>
                    <div class="w-px h-12 bg-orange-300"></div>
                    <div>
                        <div class="text-3xl font-bold">50+</div>
                        <div class="text-orange-100">Menu Variatif</div>
                    </div>
                    <div class="w-px h-12 bg-orange-300"></div>
                    <div>
                        <div class="text-3xl font-bold">10+</div>
                        <div class="text-orange-100">Tahun Pengalaman</div>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <img src="https://images.unsplash.com/photo-1555244162-803834f70033?w=600&h=500&fit=crop"
                     alt="Catering Food"
                     class="rounded-2xl shadow-2xl transform rotate-3 hover:rotate-0 transition duration-500">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Kami berkomitmen memberikan pelayanan terbaik untuk acara spesial Anda</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 rounded-xl hover:shadow-lg transition card-hover">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-award text-primary text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Kualitas Terjamin</h3>
                <p class="text-gray-600">Bahan-bahan segar dan berkualitas tinggi untuk setiap hidangan</p>
            </div>
            <div class="text-center p-6 rounded-xl hover:shadow-lg transition card-hover">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-primary text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Tepat Waktu</h3>
                <p class="text-gray-600">Pengiriman tepat waktu sesuai jadwal yang ditentukan</p>
            </div>
            <div class="text-center p-6 rounded-xl hover:shadow-lg transition card-hover">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-wallet text-primary text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Harga Kompetitif</h3>
                <p class="text-gray-600">Harga terjangkau dengan kualitas yang tidak murahan</p>
            </div>
        </div>
    </div>
</section>

<!-- Packages Section -->
<section id="paket" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Paket Catering Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Pilih paket yang sesuai dengan kebutuhan acara Anda</p>
        </div>

        @if($pakets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($pakets as $paket)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition card-hover">
                <!-- Image -->
                <!-- Image -->
<div class="relative h-64 overflow-hidden">
    @if($paket->foto1)
        <img src="{{ asset('storage/' . $paket->foto1) }}"
             alt="{{ $paket->nama_paket }}"
             class="w-full h-full object-cover hover:scale-110 transition duration-500">
    @else
        <img src="https://via.placeholder.com/400x300?text={{ urlencode($paket->nama_paket) }}"
             alt="{{ $paket->nama_paket }}"
             class="w-full h-full object-cover">
    @endif
    <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold">
        {{ $paket->jenis }}
    </div>
</div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $paket->nama_paket }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $paket->deskripsi }}</p>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-users w-5 text-primary"></i>
                            <span>{{ $paket->jumlah_pax }} Pax</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-tag w-5 text-primary"></i>
                            <span>{{ $paket->kategori }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t">
                        <div>
                            <span class="text-2xl font-bold text-primary">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</span>
                            <span class="text-gray-500 text-sm">/paket</span>
                        </div>
                        <a href="{{ route('paket.detail', $paket->id) }}"
                           class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada paket catering yang tersedia</p>
        </div>
        @endif
    </div>
</section>

<!-- How It Works Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Cara Pemesanan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Mudah dan cepat, hanya dalam 4 langkah</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                <h3 class="font-semibold text-lg mb-2">Pilih Paket</h3>
                <p class="text-gray-600 text-sm">Pilih paket catering yang sesuai dengan kebutuhan Anda</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                <h3 class="font-semibold text-lg mb-2">Isi Data</h3>
                <p class="text-gray-600 text-sm">Lengkapi data pemesanan dan alamat pengiriman</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                <h3 class="font-semibold text-lg mb-2">Pembayaran</h3>
                <p class="text-gray-600 text-sm">Lakukan pembayaran sesuai metode yang tersedia</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                <h3 class="font-semibold text-lg mb-2">Pesanan Dikirim</h3>
                <p class="text-gray-600 text-sm">Pesanan akan dikirim sesuai jadwal yang ditentukan</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 hero-gradient text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Membuat Acara Anda Berkesan?</h2>
        <p class="text-xl text-orange-100 mb-8">Pesan sekarang dan dapatkan diskon spesial untuk pemesanan pertama!</p>
        <a href="{{ route('register') }}" class="inline-block bg-white text-primary px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition transform hover:scale-105">
            Pesan Sekarang
        </a>
    </div>
</section>

@push('scripts')
<script>
    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush
@endsection
