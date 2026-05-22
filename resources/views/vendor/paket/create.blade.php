@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Paket Catering</h1>

            <form action="{{ route('vendor.paket.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Paket -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket *</label>
                        <input type="text" name="nama_paket" required value="{{ old('nama_paket') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="Paket Pernikahan Premium">
                        @error('nama_paket')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis *</label>
                        <select name="jenis" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                            <option value="">Pilih Jenis</option>
                            <option value="Prasmanan" {{ old('jenis') == 'Prasmanan' ? 'selected' : '' }}>Prasmanan</option>
                            <option value="Box" {{ old('jenis') == 'Box' ? 'selected' : '' }}>Box</option>
                        </select>
                        @error('jenis')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                        <select name="kategori" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                            <option value="">Pilih Kategori</option>
                            <option value="Pernikahan" {{ old('kategori') == 'Pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                            <option value="Selamatan" {{ old('kategori') == 'Selamatan' ? 'selected' : '' }}>Selamatan</option>
                            <option value="Ulang Tahun" {{ old('kategori') == 'Ulang Tahun' ? 'selected' : '' }}>Ulang Tahun</option>
                            <option value="Studi Tour" {{ old('kategori') == 'Studi Tour' ? 'selected' : '' }}>Studi Tour</option>
                            <option value="Rapat" {{ old('kategori') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah Pax -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pax *</label>
                        <input type="number" name="jumlah_pax" required min="1" value="{{ old('jumlah_pax') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="100">
                        @error('jumlah_pax')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Paket (Rp) *</label>
                        <input type="number" name="harga_paket" required min="0" value="{{ old('harga_paket') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="5000000">
                        @error('harga_paket')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi *</label>
                        <textarea name="deskripsi" rows="4" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                  placeholder="Deskripsi paket, menu yang termasuk, dll...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto 1 (Wajib) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Utama (Wajib) *</label>
                        <input type="file" name="foto1" accept="image/*" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Format: JPG, PNG, JPEG, GIF, WEBP (Max 2MB)
                        </p>
                        @error('foto1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto 2 (Opsional) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto 2 (Opsional)</label>
                        <input type="file" name="foto2" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        @error('foto2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto 3 (Opsional) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto 3 (Opsional)</label>
                        <input type="file" name="foto3" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        @error('foto3')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('vendor.paket.index') }}"
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                        <i class="fas fa-save mr-2"></i>Simpan Paket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
