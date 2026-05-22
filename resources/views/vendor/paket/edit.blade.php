@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Paket Catering</h1>

            <form action="{{ route('vendor.paket.update', $paket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Paket -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket *</label>
                        <input type="text" name="nama_paket" required value="{{ old('nama_paket', $paket->nama_paket) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        @error('nama_paket')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis *</label>
                        <select name="jenis" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                            <option value="Prasmanan" {{ $paket->jenis == 'Prasmanan' ? 'selected' : '' }}>Prasmanan</option>
                            <option value="Box" {{ $paket->jenis == 'Box' ? 'selected' : '' }}>Box</option>
                        </select>
                        @error('jenis')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                        <select name="kategori" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                            <option value="Pernikahan" {{ $paket->kategori == 'Pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                            <option value="Selamatan" {{ $paket->kategori == 'Selamatan' ? 'selected' : '' }}>Selamatan</option>
                            <option value="Ulang Tahun" {{ $paket->kategori == 'Ulang Tahun' ? 'selected' : '' }}>Ulang Tahun</option>
                            <option value="Studi Tour" {{ $paket->kategori == 'Studi Tour' ? 'selected' : '' }}>Studi Tour</option>
                            <option value="Rapat" {{ $paket->kategori == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah Pax -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pax *</label>
                        <input type="number" name="jumlah_pax" required min="1" value="{{ old('jumlah_pax', $paket->jumlah_pax) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        @error('jumlah_pax')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Paket (Rp) *</label>
                        <input type="number" name="harga_paket" required min="0" value="{{ old('harga_paket', $paket->harga_paket) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        @error('harga_paket')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi *</label>
                        <textarea name="deskripsi" rows="4" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto 1 -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Utama</label>
                        @if($paket->foto1)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $paket->foto1) }}" alt="Foto utama" class="w-32 h-32 object-cover rounded-lg">
                                <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                            </div>
                        @endif
                        <input type="file" name="foto1" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto</p>
                        @error('foto1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto 2 -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto 2</label>
                        @if($paket->foto2)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $paket->foto2) }}" alt="Foto 2" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="foto2" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        @error('foto2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto 3 -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto 3</label>
                        @if($paket->foto3)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $paket->foto3) }}" alt="Foto 3" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
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
                        <i class="fas fa-save mr-2"></i>Update Paket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
