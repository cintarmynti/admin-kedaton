<?php

namespace App\Exports;

use App\Models\rev_listing;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ListingExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return rev_listing::with('properti')->get();
    }

    public function map($panic) : array {
        return [
            $panic->name,
            // $panic->id,
            $panic->diskon,
            $panic->status,
            $panic->harga,
            $panic->setelah_diskon,
            $panic->properti->no_rumah,
            Carbon::parse($panic->created_at)->format('d m Y')
        ] ;
    }

    public function headings(): array
    {
        return [
            'nama',
            // 'id',
            'diskon',
            'status',
            'harga',
            'harga diskon',
            'no rumah',
            'tanggal'
        ];
    }
}
