<?php

namespace App\Exports;

use App\Models\rev_listing;
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
            $panic->id,
            $panic->diskon,
            $panic->status,
            $panic->harga,
            $panic->name,
            $panic->setelah_diskon,
            $panic->properti->no_rumah
        ] ;
    }

    public function headings(): array
    {
        return [
            'id',
            'diskon',
            'status',
            'harga',
            'nama',
            'harga diskon',
            'no rumah'
        ];
    }
}
