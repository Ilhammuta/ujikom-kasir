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

        {{-- Format Rp --}}
        <div class="mb-4">
            <label for="total_paid_display" class="block font-semibold">Total Bayar</label>
            <input 
                type="text" 
                id="total_paid_display" 
                class="border px-4 py-2 rounded w-full" 
                placeholder="Rp. 0"
                maxlength="20" 
            >
            <input type="hidden" name="total_paid" id="total_paid" required>
        </div>
        
        {{-- Pilihan Member --}}
        <div class="mb-4">
            <label class="block font-semibold">Apakah Member?</label>
            <label><input type="radio" name="is_member" value="1" required onclick="togglePhone(true)"> Ya</label>
            <label class="ml-4"><input type="radio" name="is_member" value="0" onclick="togglePhone(false)"> Bukan</label>
        </div>

        {{-- Nomor Telepon (tersembunyi default) --}}
        <div class="mb-4 hidden" id="phone-container">
            <label for="number_telephone" class="block font-semibold">Nomor Telepon</label>
            <input type="text" name="number_telephone" id="number_telephone" class="border px-4 py-2 rounded w-full">
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            Lanjutkan
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const display = document.getElementById('total_paid_display');
    const hiddenInput = document.getElementById('total_paid');

    display.addEventListener('input', function (e) {
    let rawValue = e.target.value.replace(/[^0-9]/g, '');

    // Maksimum 15 digit (Rp 999.999.999.999.999)
    if (rawValue.length > 15) {
        rawValue = rawValue.slice(0, 15); // Memotong agar panjang string maksimal 15 digit
    }

    // Konversi string angka ke number
    let numericValue = parseInt(rawValue || '0');

    // Tentukan batas maksimum (sesuai tipe data database, misalnya 15 digit)
    const MAX_TOTAL_BAYAR = 999999999999999;

    // Batasi jika melebihi maksimum
    if (numericValue > MAX_TOTAL_BAYAR) {
        numericValue = MAX_TOTAL_BAYAR;
        rawValue = numericValue.toString();
    }

    // Format ke Rp
    let formatted = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(numericValue);

    // Set value ke input
    display.value = formatted;
    hiddenInput.value = rawValue;
});

</script>
@endpush

