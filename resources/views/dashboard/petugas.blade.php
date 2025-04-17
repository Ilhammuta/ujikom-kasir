@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @if (session('success'))
        <div class="container mx-auto px-6 mt-6">
            <div class="p-4 bg-green-100 text-green-800 rounded-lg border border-green-300 shadow">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="container mx-auto px-6 py-10">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-4">
            <a href="#" class="hover:underline">Home</a> / <span class="text-gray-700 font-medium">Penjualan</span>
        </nav>

        <!-- Heading -->
        <h1 class="text-4xl font-bold text-gray-800 mb-8">Dashboard</h1>

        <!-- Card -->
        <div class="bg-white shadow-lg rounded-2xl p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Selamat Datang, Petugas!</h2>

            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center shadow-inner">
                <div class="text-gray-600 text-sm font-medium mb-2">Total Penjualan Hari Ini</div>
                <div class="text-5xl font-extrabold text-blue-600 mb-2">{{ $salesToday }}</div>
                <p class="text-gray-500 text-sm">Jumlah total penjualan yang terjadi hari ini.</p>
            </div>

            <div class="text-right text-gray-400 text-xs mt-6">
                Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
            </div>
        </div>
    </div>
@endsection
