<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    $pakets = Paket::all(); // Tampilkan semua paket dari semua vendor
    return view('home', compact('pakets'));
}

    public function dashboard()
{
    $user = auth()->user();

    // Redirect berdasarkan role
    if ($user->role === 'vendor') {
        return redirect()->route('vendor.dashboard');
    } else {
        // Customer redirect ke customer dashboard
        return redirect()->route('customer.dashboard');
    }
}
}
