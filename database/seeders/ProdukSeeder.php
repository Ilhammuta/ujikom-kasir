<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 10 produk
        $produks = collect();
        for ($i = 1; $i <= 10; $i++) {
            $produks->push(Produk::create([
                'produk' => 'Produk ' . $i,
                'harga' => rand(10000, 100000),
                'stok' => 100,
            ]));
        }

        // Buat penjualan untuk bulan kemarin (1 data)
        $penjualanBulanKemarin = Carbon::now()->subMonth()->startOfMonth()->addDays(rand(1, 28));

        $penjualan = Penjualan::create([
            'total_harga' => 0,
            'total_bayar' => 0,
            'kembalian' => 0,
            'user_id' => 7, // ganti sesuai user
            'status_member' => 'non-member',
            'created_at' => $penjualanBulanKemarin,
            'updated_at' => $penjualanBulanKemarin,
        ]);

        $total = 0;

        // Setiap penjualan ambil 1–3 produk acak
        foreach ($produks->random(rand(1, 3)) as $produk) {
            $qty = rand(1, 5);
            $subtotal = $produk->harga * $qty;

            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produk->id,
                'qty' => $qty,
            ]);

            $total += $subtotal;
        }

        // Update total untuk bulan kemarin
        $penjualan->update([
            'total_harga' => $total,
            'total_bayar' => $total,
            'kembalian' => 0,
        ]);


        // Buat penjualan untuk tahun kemarin (1 data)
        $penjualanTahunKemarin = Carbon::now()->subYear()->startOfYear()->addDays(rand(1, 365));

        $penjualan = Penjualan::create([
            'total_harga' => 0,
            'total_bayar' => 0,
            'kembalian' => 0,
            'user_id' => 1, // ganti sesuai user
            'status_member' => 'non-member',
            'created_at' => $penjualanTahunKemarin,
            'updated_at' => $penjualanTahunKemarin,
        ]);

        $total = 0;

        // Setiap penjualan ambil 1–3 produk acak
        foreach ($produks->random(rand(1, 3)) as $produk) {
            $qty = rand(1, 5);
            $subtotal = $produk->harga * $qty;

            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produk->id,
                'qty' => $qty,
            ]);

            $total += $subtotal;
        }

        // Update total untuk tahun kemarin
        $penjualan->update([
            'total_harga' => $total,
            'total_bayar' => $total,
            'kembalian' => 0,
        ]);
    }
}
