<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class PenjualanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $penjualans = Penjualan::with(['member', 'detailPenjualans.produk'])->get();

        return $penjualans->map(function ($item) {
            $produkList = $item->detailPenjualans->map(function ($dp) {
                return "{$dp->produk->produk} ( {$dp->qty} : Rp. " . number_format($dp->sub_total, 0, ',', '.') . " )";
            })->implode(' , ');

            return [
                $item->member->nama ?? 'Bukan Member',
                $item->member->telp ?? '-',
                $item->member->poin ?? '-',
                $produkList,
                'Rp. ' . number_format($item->total_harga, 0, ',', '.'),
                'Rp. ' . number_format($item->total_bayar, 0, ',', '.'),
                'Rp. ' . number_format($item->total_diskon_poin ?? 0, 0, ',', '.'),
                'Rp. ' . number_format($item->kembalian, 0, ',', '.'),
                $item->created_at->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan',
            'Produk',
            'Total Harga',
            'Total Bayar',
            'Total Diskon Poin',
            'Total Kembalian',
            'Tanggal Pembelian',
        ];
    }
}
