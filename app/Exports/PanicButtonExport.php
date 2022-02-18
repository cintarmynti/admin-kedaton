<?php

namespace App\Exports;

use App\Models\PanicButton;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PanicButtonExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PanicButton::with('user', 'properti')->get();
    }

    public function map($panic) : array {
        return [
            $panic->id,
            $panic->user->name,
            $panic->keterangan,
            $panic->status_keterangan,
        ] ;
    }

    public function headings(): array
    {
        return [
            'id',
            'nama user',
            'keterangan',
            'status_keterangan',

        ];
    }
}
