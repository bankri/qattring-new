<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja
     */
    public function index()
    {
        /** @var \App\Models\Pelanggan $user */
        $user = Auth::user();

        if ($user && $user->role === 'vendor') {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Vendor tidak memiliki akses ke keranjang belanja');
        }

        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    /**
     * Tambahkan item ke keranjang
     */
    public function add(int $id) // ← TAMBAHKAN 'int' DI SINI
    {
        /** @var \App\Models\Pelanggan $user */
        $user = Auth::user();

        if ($user && $user->role === 'vendor') {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Vendor tidak dapat memesan paket');
        }

        $paket = Paket::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            $cart[$id]['subtotal'] = $cart[$id]['quantity'] * $cart[$id]['price'];
        } else {
            $cart[$id] = [
                "name"      => $paket->nama_paket,
                "quantity"  => 1,
                "price"     => $paket->harga_paket,
                "image"     => $paket->foto1,
                "subtotal"  => $paket->harga_paket
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Paket berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update quantity item di cart
     */
    public function update(Request $request, int $id) // ← TAMBAHKAN 'int' DI SINI
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $quantity = (int) $request->input('quantity');

            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
                $cart[$id]['subtotal'] = $quantity * $cart[$id]['price'];
            } else {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Keranjang berhasil diupdate');
    }

    /**
     * Hapus item dari cart
     */
    public function remove(int $id) // ← TAMBAHKAN 'int' DI SINI
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
    }

    /**
     * Halaman Checkout
     */
    public function checkout()
    {
        /** @var \App\Models\Pelanggan $user */
        $user = Auth::user();

        if ($user && $user->role === 'vendor') {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Vendor tidak memiliki akses ke checkout');
        }

        $cart = session()->get('cart', []);

        if(empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang masih kosong');
        }

        $total = array_sum(array_map(function($item) {
            return $item['subtotal'];
        }, $cart));

        return view('cart.checkout', compact('cart', 'total'));
    }
}
