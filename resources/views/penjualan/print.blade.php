<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 40px;
        }

        h2 {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px 10px;
        }

        th {
            background-color: #f1f1f1;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .no-border {
            border: none !important;
        }

        .summary {
            margin-top: 20px;
        }

        .summary td {
            border: none;
            padding: 4px 8px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>

<body onload="window.print()">
    <h2>FlexyLite</h2>
    <p>
        Member Status : {{ $invoice->status_member === 'member' ? 'Member' : 'NON-MEMBER' }}<br>
        No. HP : {{ $invoice->member->telp ?? '000' }}<br>
        @if ($invoice->status_member === 'member')
            Bergabung Sejak : {{ \Carbon\Carbon::parse($invoice->created_at)->translatedFormat('d F Y') }}
        @else
            Bergabung Sejak: -
        @endif
        <br>
        Poin Member : {{ $invoice->member->poin ?? 0 }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th class="text-center">QTY</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->detailPenjualans as $item)
                <tr>
                    <td>{{ $item->produk->produk }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-right">Rp. {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp. {{ number_format($item->produk->harga * $item->qty, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td class="no-border">Total Harga</td>
            <td class="no-border text-right"><strong>Rp.
                    {{ number_format($invoice->total_harga, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td class="no-border">Total Bayar</td>
            <td class="no-border text-right"><strong>Rp.
                    {{ number_format($invoice->total_bayar ?? 0, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td class="no-border">Poin Digunakan</td>
            <td class="no-border text-right">{{ $invoice->poin_digunakan ?? 0 }}</td>
        </tr>
        <tr>
            <td class="no-border">Harga Setelah Poin</td>
            <td class="no-border text-right">Rp. {{ number_format($invoice->harga_setelah_poin ?? 0, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td class="no-border">Total Kembalian</td>
            <td class="no-border text-right"><strong>Rp.
                    {{ number_format($invoice->kembalian ?? 0, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="footer">
        <p>
            {{ $invoice->created_at }} | {{ $invoice->user->name }}<br>
            <strong>Terima kasih atas pembelian Anda!</strong>
        </p>
    </div>
</body>

</html>
