@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Paket Catering</h1>
            <a href="{{ route('vendor.paket.create') }}"
               class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Paket
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Paket</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pakets as $paket)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($paket->foto1)
                                <img src="{{ asset('storage/' . $paket->foto1) }}"
                                     alt="{{ $paket->nama_paket }}"
                                     class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $paket->nama_paket }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $paket->jenis == 'Prasmanan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $paket->jenis }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $paket->kategori }}</td>
                        <td class="px-6 py-4 font-semibold text-primary">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('vendor.paket.edit', $paket->id) }}"
                               class="text-blue-600 hover:text-blue-800 mr-3">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('vendor.paket.destroy', $paket->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus paket ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-3"></i>
                            <p>Belum ada paket. <a href="{{ route('vendor.paket.create') }}" class="text-primary font-medium">Tambahkan sekarang</a></p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($pakets->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $pakets->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
