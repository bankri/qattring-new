<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'pakets';

    protected $fillable = [
        'id_vendor',
        'nama_paket',
        'jenis',
        'kategori',
        'jumlah_pax',
        'harga_paket',
        'deskripsi',
        'foto1',
        'foto2',
        'foto3'
    ];

    protected $casts = [
        'harga_paket' => 'integer',
        'jumlah_pax' => 'integer'
    ];

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Pelanggan::class, 'id_vendor');
    }

    // Relasi ke Detail Pemesanan
    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class, 'id_paket');
    }
}
