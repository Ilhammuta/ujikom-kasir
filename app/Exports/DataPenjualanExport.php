<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class PenjualanExport implements FromCollection, WithHeadings, WithTitle
{
    protected $filter;
    protected $month;
    protected $year;

    public function __construct($filter, $month = null, $year = null)
    {
        $this->filter = $filter;
        $this->month = $month ?? now()->month;
        $this->year = $year ?? now()->year;
    }

    public function collection()
    {
        $penjualans = Penjualan::query();

        if ($this->filter == 'daily') {
            $penjualans->whereDate('created_at', today());
        } elseif ($this->filter == 'weekly') {
            $penjualans->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]);
        } elseif ($this->filter == 'monthly') {
            $penjualans->whereMonth('created_at', $this->month)
                ->whereYear('created_at', $this->year);
        } elseif ($this->filter == 'yearly') {
            $penjualans->whereYear('created_at', $this->year);
        } elseif ($this->filter == 'previous_month') {
            $penjualans->whereMonth('created_at', $this->month)
                ->whereYear('created_at', $this->year);
        }

        return $penjualans->with('user')->get(['id', 'created_at', 'total_harga', 'user_id'])->map(function ($penjualan) {
            return [
                'ID' => $penjualan->id,
                'Tanggal' => $penjualan->created_at->format('d M Y H:i'),
                'Total Harga' => number_format($penjualan->total_harga, 0, ',', '.'),
                'Dibuat Oleh' => $penjualan->user ? $penjualan->user->name : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Total Harga',
            'Dibuat Oleh',
        ];
    }

    public function title(): string
    {
        if ($this->filter == 'daily') {
            return 'Data Penjualan Harian';
        } elseif ($this->filter == 'weekly') {
            return 'Data Penjualan Mingguan';
        } elseif ($this->filter == 'monthly') {
            return 'Data Penjualan Bulanan ' . Carbon::create()->month($this->month)->translatedFormat('F Y');
        } elseif ($this->filter == 'yearly') {
            return 'Data Penjualan Tahunan ' . $this->year;
        } elseif ($this->filter == 'previous_month') {
            return 'Data Penjualan Bulan Sebelumnya ' . Carbon::create()->month($this->month)->translatedFormat('F Y');
        }

        return 'Data Penjualan';
    }
}
