<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pelanggans';

    protected $fillable = [
        'nama_pelanggan', 'email', 'password', 'telepon',
        'tgl_lahir', 'alamat1', 'alamat2', 'alamat3',
        'kartu_id', 'foto', 'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Helper methods
    public function isVendor()
    {
        return $this->role === 'vendor';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}
