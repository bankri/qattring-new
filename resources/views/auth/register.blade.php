@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl">
        <!-- Logo & Header -->
        <div class="text-center">
            <div class="flex justify-center">
                <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center">
                    <i class="fas fa-utensils text-white text-3xl"></i>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Buat Akun
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Bergabung dengan Qatring sekarang
            </p>
        </div>

        <!-- Register Form -->
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="space-y-4">
                <!-- Pilihan Role (Vendor/Customer) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Sebagai <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Pilihan Customer -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="role" value="customer" class="peer sr-only" checked>
                            <div class="p-3 border-2 border-gray-200 rounded-lg peer-checked:border-primary peer-checked:bg-orange-50 transition-all text-center hover:border-primary">
                                <i class="fas fa-user text-gray-400 text-2xl mb-1 peer-checked:text-primary"></i>
                                <div class="font-bold text-gray-700 peer-checked:text-primary">Customer</div>
                                <div class="text-xs text-gray-500">Pesan Catering</div>
                            </div>
                        </label>

                        <!-- Pilihan Vendor -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="role" value="vendor" class="peer sr-only">
                            <div class="p-3 border-2 border-gray-200 rounded-lg peer-checked:border-primary peer-checked:bg-orange-50 transition-all text-center hover:border-primary">
                                <i class="fas fa-store text-gray-400 text-2xl mb-1 peer-checked:text-primary"></i>
                                <div class="font-bold text-gray-700 peer-checked:text-primary">Vendor</div>
                                <div class="text-xs text-gray-500">Jual Paket</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input id="nama_pelanggan" name="nama_pelanggan" type="text" required
                            value="{{ old('nama_pelanggan') }}"
                            class="pl-10 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition @error('nama_pelanggan') border-red-500 @enderror"
                            placeholder="John Doe">
                    </div>
                    @error('nama_pelanggan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email') }}"
                            class="pl-10 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition @error('email') border-red-500 @enderror"
                            placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input id="telepon" name="telepon" type="tel" required
                            value="{{ old('telepon') }}"
                            class="pl-10 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition @error('telepon') border-red-500 @enderror"
                            placeholder="0812-3456-7890">
                    </div>
                    @error('telepon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="pl-10 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                            class="pl-10 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition"
                            placeholder="Ulangi kata sandi">
                    </div>
                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="flex items-start">
                <input id="terms" name="terms" type="checkbox" required
                    class="mt-1 h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-700">
                    Saya setuju dengan
                    <a href="#" class="text-primary hover:text-orange-700 font-medium">Syarat & Ketentuan</a>
                    dan
                    <a href="#" class="text-primary hover:text-orange-700 font-medium">Kebijakan Privasi</a>
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition transform hover:scale-105">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-orange-500 group-hover:text-orange-400"></i>
                    </span>
                    Daftar Sekarang
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-primary hover:text-orange-700">
                        Masuk sekarang
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
