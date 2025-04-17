@extends('layouts.app')

@section('title', 'Member')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Data Member</h1>

    <form action="{{ route('sales.member') }}" method="POST" class="space-y-6">
        @csrf

        @if (isset($member))
            <input type="hidden" name="member_id" value="{{ $member->id }}">

            {{-- Informasi Member --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Nama Member</label>
                    <input type="text" name="nama" value="{{ $member->nama }}" readonly
                        class="border px-4 py-2 rounded w-full bg-gray-100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Nomor Telepon</label>
                    <input type="text" name="telp" value="{{ $member->telp }}" readonly
                        class="border px-4 py-2 rounded w-full bg-gray-100">
                </div>
            </div>

            {{-- Detail Produk --}}
            <div>
                <h2 class="text-lg font-semibold mb-3">Detail Produk yang Dibeli</h2>
                <div class="border rounded p-4 space-y-3 bg-white shadow">
                    @foreach ($orders as $item)
                        <div class="flex justify-between border-b pb-2">
                            <div>
                                <p class="font-medium">{{ $item['product']->produk }}</p>
                                <p class="text-sm text-gray-600">
                                    Harga: Rp {{ number_format($item['product']->harga, 0, ',', '.') }} <br>
                                    Qty: {{ $item['quantity'] }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">
                                    Subtotal: Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-between pt-3 text-lg font-bold">
                        <span>Total Harga</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        @else
            {{-- Form Tambah Member Baru --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Nama Member</label>
                    <input type="text" name="nama" required class="border px-4 py-2 rounded w-full">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Nomor Telepon</label>
                    <input type="text" name="telp" value="{{ $number_telephone }}" required class="border px-4 py-2 rounded w-full">
                </div>
            </div>
        @endif

        {{-- Input Hidden Data --}}
        <input type="hidden" name="total_harga" value="{{ $totalPrice }}">
        <input type="hidden" name="total_bayar" value="{{ $totalPaid }}">

        @foreach ($orders as $index => $order)
            <input type="hidden" name="orders[{{ $index }}][product_id]" value="{{ $order['product']->id }}">
            <input type="hidden" name="orders[{{ $index }}][quantity]" value="{{ $order['quantity'] }}">
            <input type="hidden" name="orders[{{ $index }}][subtotal]" value="{{ $order['subtotal'] }}">
        @endforeach

        {{-- Gunakan Point --}}
        <div>
            <label class="block font-semibold mb-2">Gunakan Point?</label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="poin_dipakai" class="mr-2">
                Gunakan {{ $point ?? 0 }} point
            </label>
        </div>

        {{-- Submit Button --}}
        <div class="text-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                Selesaikan Pembelian
            </button>
        </div>
    </form>
</div>
@endsection
