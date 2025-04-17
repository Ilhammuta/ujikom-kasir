@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Checkout</h1>

    <form action="{{ route('sales.process.member') }}" method="POST">
        @csrf
        <table class="w-full mb-4 text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">Produk</th>
                    <th class="p-2 border">Harga</th>
                    <th class="p-2 border">Jumlah</th>
                    <th class="p-2 border">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                    <tr>
                        <td class="p-2 border">{{ $item['product']->produk }}</td>
                        <td class="p-2 border">Rp. {{ number_format($item['product']->harga, 0, ',', '.') }}</td>
                        <td class="p-2 border">{{ $item['quantity'] }}</td>
                        <td class="p-2 border">Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                    <input type="hidden" name="orders[{{ $loop->index }}][product_id]" value="{{ $item['product']->id }}">
                    <input type="hidden" name="orders[{{ $loop->index }}][quantity]" value="{{ $item['quantity'] }}">
                    <input type="hidden" name="orders[{{ $loop->index }}][subtotal]" value="{{ $item['subtotal'] }}">
                @endforeach
            </tbody>
        </table>

        <div class="mb-4">
            <p>Total Harga: <strong>Rp. {{ number_format($totalPrice, 0, ',', '.') }}</strong></p>
            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
        </div>

        <div class="mb-4">
            <label for="total_paid" class="block font-semibold">Total Bayar</label>
            <input type="number" name="total_paid" id="total_paid" required class="border px-4 py-2 rounded w-full" >
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Apakah Member?</label>
            <label><input type="radio" name="is_member" value="1" required> Ya</label>
            <label class="ml-4"><input type="radio" name="is_member" value="0"> Bukan</label>
        </div>

        <div class="mb-4">
            <label for="number_telephone" class="block font-semibold">Nomor Telepon</label>
            <input type="text" name="number_telephone" class="border px-4 py-2 rounded w-full">
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            Lanjutkan
        </button>
    </form>
</div>

@endsection
