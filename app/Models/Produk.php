<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    
    protected $fillable = [
        'image',
        'produk',
        'harga',
        'stok',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : asset('images/default.png');
    }

    // Di model Produk
    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
