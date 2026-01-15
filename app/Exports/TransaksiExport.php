<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Transaksi::with(['user', 'details']);

        if ($this->request->filled('tanggal')) {
            $query->whereDate('created_at', $this->request->tanggal);
        }

        if ($this->request->filled('bulan')) {
            $query->whereMonth('created_at', $this->request->bulan);
        }

        if ($this->request->filled('tahun')) {
            $query->whereYear('created_at', $this->request->tahun);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No Invoice',
            'Tanggal',
            'Kasir',
            'Total',
            'Metode',
            'Status'
        ];
    }

    public function map($trx): array
    {
        return [
            optional($trx->details->first())->no_invoice ?? '-',
            $trx->created_at->format('d/m/Y H:i'),
            $trx->user->nama ?? '-',
            $trx->total,
            $trx->metode ?? '-',
            $trx->status
        ];
    }
}
