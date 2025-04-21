@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <div class="container mx-auto p-6">
        <nav class="text-sm text-gray-500 mb-2">
            <a href="#" class="hover:underline">Home</a> / <span>Produk</span>
        </nav>
        <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>

        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="bg-white p-6 rounded shadow-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="produk" class="w-full p-2 border rounded" value="{{ old('produk', $produk->produk) }}" required>
                        @error('produk')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Gambar Produk</label>
                        <input type="file" name="image" class="w-full p-2 border rounded" accept="image/*">
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        @if ($produk->image)
                            <div class="mt-2">
                                <label class="text-sm text-gray-600">Gambar Saat Ini:</label>
                                <img src="{{ asset('storage/' . $produk->image) }}" alt="{{ $produk->produk }}" class="w-full h-auto max-w-[100px] object-cover rounded shadow">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Harga <span class="text-red-500">*</span></label>
                        <input type="text" name="harga_display" id="harga" class="w-full p-2 border rounded"
                            value="Rp {{ number_format($produk->harga, 0, ',', '.') }}" required>
                        <input type="hidden" name="harga" id="harga_hidden" value="{{ $produk->harga }}">
                        @error('harga')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stok" class="w-full p-2 border rounded" value="{{ old('stok', $produk->stok) }}" readonly required>
                        @error('stok')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 text-right">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow-md hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputHarga = document.getElementById('harga');
            const hiddenHarga = document.getElementById('harga_hidden');

            inputHarga.addEventListener('input', () => {
                let raw = inputHarga.value.replace(/\D/g, '');
                if (raw) {
                    inputHarga.value = 'Rp ' + parseInt(raw).toLocaleString('id-ID');
                    hiddenHarga.value = parseInt(raw);
                } else {
                    inputHarga.value = '';
                    hiddenHarga.value = '';
                }
            });
        });
    </script>
@endsection
