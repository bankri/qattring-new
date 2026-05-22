<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Qatring - Jasa Catering Online Terpercaya')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#EA580C',
                        secondary: '#F97316',
                        dark: '#1F2937',
                    }
                }
            }
        }
    </script>

    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #EA580C 0%, #F97316 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-primary">
                        <i class="fas fa-utensils mr-2"></i>Qatring
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary font-medium transition">Beranda</a>
                    <a href="#paket" class="text-gray-700 hover:text-primary font-medium transition">Paket</a>
                    <a href="#tentang" class="text-gray-700 hover:text-primary font-medium transition">Tentang</a>
                    <a href="#kontak" class="text-gray-700 hover:text-primary font-medium transition">Kontak</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <!-- Tampilkan cart hanya untuk customer -->
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('customer.cart') }}" class="relative text-gray-700 hover:text-primary">
                                <i class="fas fa-shopping-cart text-xl"></i>
                                @if(session('cart'))
                                    <span class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ count(session('cart')) }}
                                    </span>
                                @endif
                            </a>
                        @endif

                        @if(auth()->user()->role === 'vendor')
    <a href="{{ route('vendor.dashboard') }}" class="text-primary font-medium">
        <i class="fas fa-store mr-1"></i>Dashboard Vendor
    </a>
@else
    <a href="{{ route('customer.dashboard') }}" class="text-gray-700 hover:text-primary font-medium">
        <i class="fas fa-user mr-1"></i>Dashboard
    </a>
@endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-primary focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Beranda</a>
                <a href="#paket" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Paket</a>
                <a href="#tentang" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Tentang</a>
                <a href="#kontak" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Kontak</a>

                @auth
                    <!-- Tampilkan cart hanya untuk customer -->
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.cart') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">
                            Keranjang
                            @if(session('cart'))
                                <span class="bg-primary text-white text-xs rounded-full px-2 py-1 ml-2">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if(auth()->user()->role === 'vendor')
    <a href="{{ route('vendor.dashboard') }}" class="block px-3 py-2 text-primary font-medium hover:bg-orange-50 rounded-md">
        <i class="fas fa-store mr-1"></i>Dashboard Vendor
    </a>
@else
    <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">
        <i class="fas fa-user mr-1"></i>Dashboard
    </a>
@endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700 hover:bg-orange-50 rounded-md">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-primary font-medium hover:bg-orange-50 rounded-md">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 max-w-7xl mx-auto" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 max-w-7xl mx-auto" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-4">
                        <i class="fas fa-utensils mr-2"></i>Qatring
                    </h3>
                    <p class="text-gray-400">Jasa catering online terpercaya untuk berbagai acara Anda. Rasa berkualitas, harga terjangkau.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Menu</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="#paket" class="hover:text-white transition">Paket Catering</a></li>
                        <li><a href="#tentang" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#kontak" class="hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Catering Pernikahan</a></li>
                        <li><a href="#" class="hover:text-white transition">Catering Rapat</a></li>
                        <li><a href="#" class="hover:text-white transition">Catering Ulang Tahun</a></li>
                        <li><a href="#" class="hover:text-white transition">Catering Selamatan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                            <span>Jl. Contoh No. 123<br>Jakarta, Indonesia 12345</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-primary"></i>
                            <span>0812-3456-7890</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary"></i>
                            <span>info@qatring.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-primary"></i>
                            <span>Senin - Sabtu: 08.00 - 17.00</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Qatring. All rights reserved.</p>
                <p class="mt-2 text-sm">Dibuat dengan <i class="fas fa-heart text-red-500"></i> untuk Indonesia</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-btn');

            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        // Close mobile menu if open
                        document.getElementById('mobile-menu').classList.add('hidden');
                    }
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
