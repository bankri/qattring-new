<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function show($id)
    {
        $paket = Paket::findOrFail($id);
        return view('paket.detail', compact('paket'));
    }
}
