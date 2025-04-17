<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_penjualan',
        'total_harga',
        'total_bayar',
        'kembalian',
        'dibuat_oleh',
        'status_member',
        'member_id',
        'poin_dipakai',
        'poin_didapat'
    ];

    protected $casts = [
        'tanggal_penjualan' => 'datetime',
    ];

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
