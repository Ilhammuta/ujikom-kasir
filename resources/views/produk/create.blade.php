@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <div class="container mx-auto p-6">
        <nav class="text-sm text-gray-500 mb-2">
            <a href="#" class="hover:underline">Home</a> / <span>Produk</span>
        </nav>
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Produk</h1>

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="produk" class="w-full p-2 border rounded" required value="{{ old('produk') }}">
                        @error('produk')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk <span class="text-red-500">*</span></label>
                        <input type="file" name="image" class="w-full p-2 border rounded" accept="image/*" required>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga <span class="text-red-500">*</span></label>
                        <input type="text" name="harga_display" id="harga" class="w-full p-2 border rounded" required  >
                        <input type="hidden" name="harga" id="harga_hidden">
                        @error('harga')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stok" class="w-full p-2 border rounded" required value="{{ old('stok') }}">
                        @error('stok')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 text-right">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md shadow hover:bg-blue-700 transition">
                        Simpan
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
                let cleaned = inputHarga.value.replace(/[^0-9]/g, '');
                if (cleaned) {
                    let formatted = new Intl.NumberFormat('id-ID').format(cleaned);
                    inputHarga.value = 'Rp ' + formatted;
                    hiddenHarga.value = cleaned;
                } else {
                    inputHarga.value = '';
                    hiddenHarga.value = '';
                }
            });
        });
    </script>
@endsection
