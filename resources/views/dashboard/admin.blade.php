@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-6 space-y-6">
        <nav class="text-sm text-gray-500">
            <a href="#" class="hover:underline">Home</a> / <span>Penjualan</span>
        </nav>

        <div>
            <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
            <p class="text-lg text-gray-600">Selamat Datang, Administrator!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Jumlah Penjualan per Hari</h3>
                <div id="container" class="w-full h-80"></div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Persentase Penjualan Produk</h3>
                <div id="con" class="w-full h-80"></div>
            </div>
        </div>
    </div>

    <script>
        console.log("TANGGAL:", {!! json_encode($dates) !!});
        console.log("TOTAL:", {!! json_encode($totals) !!});
        console.log("PRODUK:", {!! json_encode($productSales) !!});
    </script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            exporting: {
                enabled: false
            },  
            xAxis: {
                categories: {!! json_encode($dates) !!},
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Penjualan'
                }
            },
            tooltip: {
                valueSuffix: ' transaksi'
            },
            series: [{
                name: 'Jumlah Penjualan',
                data: {!! json_encode($totals) !!}
            }]
        });
    </script>

    <script>
        Highcharts.chart('con', {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },
            exporting: {
                enabled: false
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    showInLegend: true,
                    dataLabels: {
                        enabled: false
                    }
                }
            },
            series: [{
                name: 'Produk',
                colorByPoint: true,
                data: {!! json_encode($productSales) !!}
            }]
        });
    </script>
@endsection
