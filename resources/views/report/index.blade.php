@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold mb-6">Laporan Penjualan</h1>

        <div class="bg-white shadow p-6 rounded-xl">
            <a href="{{ route('dashboard.petugas') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg mb-6 hover:bg-blue-600 transition duration-300">
                Kembali ke Dashboard Petugas
            </a>

            <a href="{{ route('laporan.penjualan.excel', [
                 'filter' => request('filter'),
                 'month' => request('month'),
                 'year' => request('year')]) }}"
                class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg mb-6 hover:bg-green-600 transition duration-300">
             Unduh Laporan Excel
            </a>


            <!-- Form Filter -->
            <form action="{{ route('report.index') }}" method="GET" class="mb-6">
                <div class="flex space-x-4">
                    <!-- Filter berdasarkan pilihan -->
                    <div>
                        <label for="filter" class="block text-sm font-semibold">Pilih Filter</label>
                        <select name="filter" id="filter" class="bg-gray-100 border p-2 rounded-md" onchange="toggleFilters()">
                            <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Harian</option>
                            <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="yearly" {{ $filter == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>

                    <div id="month-filter" class="hidden">
                        <label for="month" class="block text-sm font-semibold">Pilih Bulan</label>
                        <select name="month" id="month" class="bg-gray-100 border p-2 rounded-md">
                            @php
                                $selectedYear = request()->input('year', now()->year);
                            @endphp
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $m == (int) request()->input('month') ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromDate($selectedYear, $m)->translatedFormat('F Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="year-filter" class="hidden">
                        <label for="year" class="block text-sm font-semibold">Pilih Tahun</label>
                        <select name="year" id="year" class="bg-gray-100 border p-2 rounded-md">
                            @for($y = now()->year; $y >= now()->subYears(5)->year; $y--)
                                <option value="{{ $y }}" {{ $y == (int) request()->input('year', now()->year) ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>                  

                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Terapkan Filter</button>
                    </div>
                </div>
            </form>

            <p class="text-gray-700 mb-4">
                Menampilkan laporan penjualan:
                <strong>
                    @if($filter == 'monthly')
                        Bulan {{ \Carbon\Carbon::createFromDate($year ?? now()->year, $month ?? now()->month)->translatedFormat('F Y') }}
                    @elseif($filter == 'yearly')
                        Tahun {{ $year ?? now()->year }}
                    @else
                        Harian
                    @endif
                </strong>
            </p>

            @if($filter === 'daily')
                <p class="text-gray-600 mb-2">Tanggal: {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>
            @elseif($filter === 'monthly')
                <p class="text-gray-600 mb-2">
                    Bulan: {{ \Carbon\Carbon::createFromDate($year ?? now()->year, $month ?? now()->month)->translatedFormat('F Y') }}
                </p>
            @elseif($filter === 'yearly')
                <p class="text-gray-600 mb-2">
                    Tahun: {{ $year ?? now()->year }}
                </p>
            @endif

            <p class="text-gray-700 font-semibold mb-4">
                Total Transaksi: {{ $penjualans->count() }}
            </p>

            @if($penjualans->isEmpty())
                <p class="text-gray-500 italic">Belum ada data penjualan untuk filter ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Total Harga</th>
                                <th class="px-4 py-2 border">Dibuat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualans as $penjualan)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $penjualan->id }}</td>
                                    <td class="px-4 py-2 border">{{ $penjualan->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2 border">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border">{{ $penjualan->user->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleFilters() {
            const filter = document.getElementById('filter').value;
            const monthFilter = document.getElementById('month-filter');
            const yearFilter = document.getElementById('year-filter');

            monthFilter.classList.add('hidden');
            yearFilter.classList.add('hidden');

            if (filter === 'monthly') {
                monthFilter.classList.remove('hidden');
                yearFilter.classList.remove('hidden'); 
            } else if (filter === 'yearly') {
                yearFilter.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', toggleFilters);
    </script>
@endsection
