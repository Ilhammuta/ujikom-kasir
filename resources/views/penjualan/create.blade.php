@extends('layouts.app')

@section('title', 'Index')

@section('content')
<div class="container mx-auto p-6">
        <nav class="text-sm text-gray-500">
            <a href="#" class="hover:underline">Home</a> / <span>Penjualan</span>
        </nav>
        <h1 class="text-3xl font-bold mb-6">Penjualan</h1>
        <form action="{{ route('sales.process.product') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($data as $produk)
                    <div class="border rounded-lg shadow p-4 flex flex-col items-center">
                        <img src="{{ $produk->image_url }}" alt="{{ $produk->produk }}"
                            class="w-40 h-40 object-cover rounded-lg mb-4">
                        <h2 class="text-xl font-semibold mb-1">{{ $produk->produk }}</h2>
                        <p class="text-gray-600 mb-1">Stok {{ $produk->stok }}</p>
                        <p class="mb-2 font-semibold text-gray-800">Rp. {{ number_format($produk->harga, 0, ',', '.') }}</p>

                        <div class="flex items-center space-x-4">
                            <button type="button" class="px-3 py-1 bg-gray-200 rounded font-bold text-lg"
                                onclick="kurang('{{ $produk->id }}')">-</button>

                            <input type="number" id="jumlah_{{ $produk->id }}" name="jumlah[{{ $produk->id }}]"
                                value="0" min="0" max="{{ $produk->stok }}"
                                class="w-12 text-center border rounded" readonly>

                            <button type="button"
                                class="px-3 py-1 text-white font-bold text-lg rounded 
                                {{ $produk->stok == 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600' }}"
                                {{ $produk->stok == 0 ? 'disabled' : '' }}
                                onclick="tambah('{{ $produk->id }}', {{ $produk->stok }})">
                                +
                            </button>
                        </div>

                        <p class="mt-4 text-sm text-gray-700">Sub Total <strong>Rp. <span
                                    id="subtotal_{{ $produk->id }}">0</span></strong></p>
                    </div>
                @endforeach
            </div>

            <div class="text-right mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Selanjutnya
                </button>
            </div>
        </form>
    </div>

    <script>
        function tambah(id, stok) {
            let input = document.getElementById('jumlah_' + id);
            let subtotal = document.getElementById('subtotal_' + id);
            let val = parseInt(input.value);

            if (val < stok) {
                input.value = val + 1;
                hitungSubtotal(id);
            }
        }

        function kurang(id) {
            let input = document.getElementById('jumlah_' + id);
            let subtotal = document.getElementById('subtotal_' + id);
            let val = parseInt(input.value);

            if (val > 0) {
                input.value = val - 1;
                hitungSubtotal(id);
            }
        }

        function hitungSubtotal(id) {
            let input = document.getElementById('jumlah_' + id);
            let harga = @json($data->pluck('harga', 'id'));
            let subtotal = document.getElementById('subtotal_' + id);
            let jumlah = parseInt(input.value);
            subtotal.innerText = (jumlah * harga[id]).toLocaleString('id-ID');
        }
    </script>
@endsection
