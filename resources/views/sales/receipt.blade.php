@extends('layouts.app')

@section('title', 'Struk Penjualan')

@section('content')
<div class="container mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Struk Penjualan</h1>

    <div class="space-y-2 text-gray-800 text-sm mb-4">
        <p><strong>ID Penjualan:</strong> {{ $penjualan->id }}</p>
        <p><strong>Tanggal Transaksi:</strong> {{ $penjualan->created_at->format('d-m-Y H:i') }}</p>
        <p><strong>Kasir:</strong> {{ auth()->user()->name }}</p>

        @if ($penjualan->member)
            <p><strong>Member:</strong> {{ $penjualan->member->nama }} ({{ $penjualan->member->telp }})</p>
        @endif
    </div>

    <table class="w-full my-4 border-collapse text-sm text-left">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="border px-2 py-1">Produk</th>
                <th class="border px-2 py-1 text-center">Jumlah</th>
                <th class="border px-2 py-1 text-right">Harga</th>
                <th class="border px-2 py-1 text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penjualan->detailPenjualans as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border px-2 py-1">{{ $item->produk->produk }}</td>
                    <td class="border px-2 py-1 text-center">{{ $item->qty }}</td>
                    <td class="border px-2 py-1 text-right">Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="border px-2 py-1 text-right">Rp. {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border px-2 py-2 text-center text-gray-500">Tidak ada item dalam transaksi ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="text-right text-sm space-y-1 text-gray-800">
        <p><strong>Total:</strong> Rp. {{ number_format($penjualan->total_harga, 0, ',', '.') }}</p>
        <p><strong>Dibayar:</strong> Rp. {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> Rp. {{ number_format($penjualan->kembalian, 0, ',', '.') }}</p>

        @if ($penjualan->member)
            @if ($penjualan->poin_dipakai)
                <p><strong>Poin Dipakai:</strong> {{ $penjualan->poin_dipakai }}</p>
            @endif

            @if ($penjualan->poin_didapat)
                <p><strong>Poin Didapat:</strong> {{ $penjualan->poin_didapat }}</p>
            @endif

            @if ($penjualan->harga_setelah_poin)
                <p><strong>Harga Setelah Poin:</strong> Rp. {{ number_format($penjualan->harga_setelah_poin, 0, ',', '.') }}</p>
            @endif
        @endif  
    </div>

    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('penjualan.index') }}"
           class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded text-sm">
            Kembali
        </a>
        <a href="{{ route('penjualan.pdf', $penjualan->id) }}"
           class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded text-sm">
            Unduh Bukti
        </a>
    </div>
</div>


@endsection
