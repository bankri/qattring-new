<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    protected $table = 'detail_pemesanans';

    protected $fillable = [
        'id_pemesanan',
        'id_paket',
        'id_vendor',
        'subtotal'
    ];

    protected $casts = [
        'subtotal' => 'integer',
    ];

    // Relasi ke Pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    // Relasi ke Paket
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Pelanggan::class, 'id_vendor');
    }
}
