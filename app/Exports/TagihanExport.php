<?php

namespace App\Exports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TagihanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tagihan::with('nomer', 'cluster','type')->get();
    }

    public function map($tagihan) : array {
        return [
            $tagihan->id,
            $tagihan->cluster->name,
            $tagihan->nomer->no_rumah,
            $tagihan->periode_pembayaran,
            $tagihan->jumlah_pembayaran,
            $tagihan->type->name,
            $tagihan->status == 2  ? 'Sudah dibayar' : 'pending',
        ];
    }

    public function headings(): array
    {
        return [
           'id',
           'cluster',
           'no rumah',
            'periode pembayaran',
            'jumlah pembayaran',
            'type',
            'status tagihan'
        ];
    }
}
