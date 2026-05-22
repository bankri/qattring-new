<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';

    protected $fillable = [
        'id_pelanggan',
        'id_jenis_bayar',
        'id_pengiriman',
        'no_resi',
        'tgl_pesan',
        'tgl_pengiriman',
        'status_pesan',
        'status',
        'vendor_notes',
        'rejected_reason',
        'total_bayar',
        'confirmed_at',
        'paid_at',
        'sent_at',
        'completed_at'
    ];

    protected $casts = [
        'tgl_pesan' => 'datetime',
        'tgl_pengiriman' => 'datetime',
        'confirmed_at' => 'datetime',
        'paid_at' => 'datetime',
        'sent_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_bayar' => 'integer',
    ];

    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_WAITING_PAYMENT = 'waiting_payment';
    const STATUS_PAID = 'paid';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_SENT = 'sent';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REJECTED = 'rejected';

    // Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi ke Detail Pemesanan
    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class, 'id_pemesanan');
    }

    // Relasi ke Jenis Pembayaran
    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'id_jenis_bayar');
    }

    // Helper: Format status untuk tampilan
    public function getStatusBadgeAttribute()
    {
        $colors = [
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_WAITING_PAYMENT => 'bg-orange-100 text-orange-800',
            self::STATUS_PAID => 'bg-blue-100 text-blue-800',
            self::STATUS_IN_PROGRESS => 'bg-purple-100 text-purple-800',
            self::STATUS_SENT => 'bg-indigo-100 text-indigo-800',
            self::STATUS_COMPLETED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-gray-100 text-gray-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
        ];

        $labels = [
    self::STATUS_PENDING => 'Menunggu Konfirmasi',  // Lebih pendek
    self::STATUS_WAITING_PAYMENT => 'Menunggu Bayar',
    self::STATUS_PAID => 'Sudah Dibayar',
    self::STATUS_IN_PROGRESS => 'Sedang Diproses',
    self::STATUS_SENT => 'Dikirim',
    self::STATUS_COMPLETED => 'Selesai',
    self::STATUS_CANCELLED => 'Dibatalkan',
    self::STATUS_REJECTED => 'Ditolak',
];

        $status = $this->status;
        $color = $colors[$status] ?? 'bg-gray-100 text-gray-800';
        $label = $labels[$status] ?? $status;

        return "<span class='px-3 py-1 text-sm font-semibold rounded-full {$color}'>{$label}</span>";
    }

    // Helper: Cek apakah bisa dibatalkan customer
    public function canCancelByCustomer()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_WAITING_PAYMENT]);
    }

    // Helper: Cek apakah bisa dikonfirmasi vendor
    public function canConfirmByVendor()
    {
        return $this->status === self::STATUS_PENDING;
    }

    // Helper: Cek apakah bisa dikirim vendor
    public function canSendByVendor()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    // Helper: Cek apakah bisa dikonfirmasi customer
    public function canConfirmReceived()
    {
        return $this->status === self::STATUS_SENT;
    }

public function ordersAsCourier()
{
    return $this->hasMany(Pemesanan::class, 'id_kurir');
}

public function kurir()
{
    return $this->belongsTo(Pelanggan::class, 'id_kurir');
}

public function vendor()
{
    return $this->belongsTo(Pelanggan::class, 'id_pelanggan'); // Sesuaikan jika vendor pakai tabel terpisah
}



}
