<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    /**
     * Tampilkan daftar paket milik vendor
     */
    public function index()
    {
        $pakets = Paket::where('id_vendor', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('vendor.paket.index', compact('pakets'));
    }

    /**
     * Tampilkan form tambah paket
     */
    public function create()
    {
        return view('vendor.paket.create');
    }

    /**
     * Simpan paket baru dengan upload foto
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:50',
            'jenis' => 'required|in:Prasmanan,Box',
            'kategori' => 'required|in:Pernikahan,Selamatan,Ulang Tahun,Studi Tour,Rapat',
            'jumlah_pax' => 'required|integer|min:1',
            'harga_paket' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'foto1' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['id_vendor'] = Auth::id();

        // Upload Foto 1 (Wajib)
        if ($request->hasFile('foto1')) {
            $validated['foto1'] = $request->file('foto1')->store('pakets', 'public');
        }

        // Upload Foto 2 (Opsional)
        if ($request->hasFile('foto2')) {
            $validated['foto2'] = $request->file('foto2')->store('pakets', 'public');
        }

        // Upload Foto 3 (Opsional)
        if ($request->hasFile('foto3')) {
            $validated['foto3'] = $request->file('foto3')->store('pakets', 'public');
        }

        Paket::create($validated);

        return redirect()->route('vendor.paket.index')
            ->with('success', 'Paket berhasil ditambahkan!');
    }

    /**
     * Tampilkan paket untuk diedit
     */
    public function edit($id)
    {
        $paket = Paket::where('id', $id)
            ->where('id_vendor', Auth::id())
            ->firstOrFail();

        return view('vendor.paket.edit', compact('paket'));
    }

    /**
     * Update paket dengan upload foto baru
     */
    public function update(Request $request, $id)
    {
        $paket = Paket::where('id', $id)
            ->where('id_vendor', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'nama_paket' => 'required|string|max:50',
            'jenis' => 'required|in:Prasmanan,Box',
            'kategori' => 'required|in:Pernikahan,Selamatan,Ulang Tahun,Studi Tour,Rapat',
            'jumlah_pax' => 'required|integer|min:1',
            'harga_paket' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Upload Foto 1 (jika ada file baru)
        if ($request->hasFile('foto1')) {
            // Hapus foto lama
            if ($paket->foto1) {
                Storage::disk('public')->delete($paket->foto1);
            }
            $validated['foto1'] = $request->file('foto1')->store('pakets', 'public');
        }

        // Upload Foto 2 (jika ada file baru)
        if ($request->hasFile('foto2')) {
            if ($paket->foto2) {
                Storage::disk('public')->delete($paket->foto2);
            }
            $validated['foto2'] = $request->file('foto2')->store('pakets', 'public');
        }

        // Upload Foto 3 (jika ada file baru)
        if ($request->hasFile('foto3')) {
            if ($paket->foto3) {
                Storage::disk('public')->delete($paket->foto3);
            }
            $validated['foto3'] = $request->file('foto3')->store('pakets', 'public');
        }

        // Hapus field yang tidak ada file upload (biar foto lama tetap ada)
        unset($validated['foto1'], $validated['foto2'], $validated['foto3']);

        $paket->update($validated);

        return redirect()->route('vendor.paket.index')
            ->with('success', 'Paket berhasil diperbarui!');
    }

    /**
     * Hapus paket beserta fotonya
     */
    public function destroy($id)
    {
        $paket = Paket::where('id', $id)
            ->where('id_vendor', Auth::id())
            ->firstOrFail();

        // Hapus semua foto
        if ($paket->foto1) {
            Storage::disk('public')->delete($paket->foto1);
        }
        if ($paket->foto2) {
            Storage::disk('public')->delete($paket->foto2);
        }
        if ($paket->foto3) {
            Storage::disk('public')->delete($paket->foto3);
        }

        $paket->delete();

        return redirect()->route('vendor.paket.index')
            ->with('success', 'Paket berhasil dihapus!');
    }
}
