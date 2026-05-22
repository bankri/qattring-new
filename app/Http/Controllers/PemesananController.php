<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemesananController extends Controller
{
    /**
     * Simpan pesanan (redirect ke Customer\OrderController)
     */
    public function store(Request $request)
    {
        // Redirect ke controller yang lebih lengkap
        return app(\App\Http\Controllers\Customer\OrderController::class)->store($request);
    }
}
