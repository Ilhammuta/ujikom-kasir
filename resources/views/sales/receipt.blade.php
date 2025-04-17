@extends('layouts.app')

@section('title', 'Struk Penjualan')

@section('content')
<div class="container mx-auto p-6">
    <a href="{{ route('penjualan.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>

    <h1 class="text-xl font-bold mb-4">Struk Penjualan</h1>

    <p><strong>ID Penjualan:</strong> {{ $penjualan->id }}</p>
    <p><strong>Tanggal:</strong> {{ $penjualan->created_at->format('d-m-Y H:i') }}</p>
    <p><strong>Kasir:</strong> {{ auth()->user()->name }}</p>

    @if ($penjualan->member)
        <p><strong>Member:</strong> {{ $penjualan->member->nama }} ({{ $penjualan->member->telp }})</p>
    @endif

    <table class="w-full my-4 border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">Produk</th>
                <th class="border px-2 py-1">Jumlah</th>
                <th class="border px-2 py-1">Harga</th>
                <th class="border px-2 py-1">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan->detailPenjualans as $item)
                <tr>
                    <td class="border px-2 py-1">{{ $item->produk->produk }}</td>
                    <td class="border px-2 py-1">{{ $item->qty }}</td>
                    <td class="border px-2 py-1">Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="border px-2 py-1">Rp. {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <p><strong>Total:</strong> Rp. {{ number_format($penjualan->total_harga, 0, ',', '.') }}</p>
        <p><strong>Dibayar:</strong> Rp. {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> Rp. {{ number_format($penjualan->kembalian, 0, ',', '.') }}</p>

        @if ($penjualan->poin_dipakai)
            <p><strong>Point Dipakai:</strong> {{ $penjualan->poin_dipakai }}</p>
        @endif
        @if ($penjualan->poin_didapat)
            <p><strong>Point Didapat:</strong> {{ $penjualan->poin_didapat }}</p>
        @endif
    </div>
</div>
@endsection
