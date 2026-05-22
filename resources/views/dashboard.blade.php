@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Dashboard Header -->
    <div class="hero-gradient text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <p class="text-orange-100">Selamat datang, {{ auth()->user()->nama_pelanggan ?? auth()->user()->name }}! 👋</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">0</div>
                        <div class="text-gray-500 text-sm">Total Pesanan</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">0</div>
                        <div class="text-gray-500 text-sm">Selesai</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">0</div>
                        <div class="text-gray-500 text-sm">Diproses</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-wallet text-white text-xl"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">Rp 0</div>
                        <div class="text-gray-500 text-sm">Total Belanja</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow">
                    <div class="p-6 border-b flex justify-between items-center">
                        <h3 class="text-xl font-bold">Riwayat Pesanan</h3>
                        <a href="#" class="text-primary text-sm font-medium hover:underline">Lihat Semua</a>
                    </div>
                    <div class="p-6">
                        <div class="text-center py-12 text-gray-500">
                            <i class="fas fa-receipt text-4xl mb-3"></i>
                            <p>Belum ada pesanan</p>
                            <a href="{{ route('home') }}" class="text-primary font-medium mt-2 inline-block">Mulai Belanja →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile & Quick Actions -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-primary text-3xl"></i>
                        </div>
                        <h4 class="font-semibold text-lg">{{ auth()->user()->nama_pelanggan ?? auth()->user()->name }}</h4>
                        <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
                        <a href="#" class="text-primary text-sm font-medium mt-2 inline-block">Edit Profil →</a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h4 class="font-semibold mb-4">Aksi Cepat</h4>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-utensils text-primary"></i>
                            <span>Lihat Paket</span>
                        </a>
                        <a href="{{ route('customer.cart') }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span>Keranjang</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-headset text-primary"></i>
                            <span>Bantuan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
