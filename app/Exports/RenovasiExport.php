<?php

namespace App\Exports;

use App\Models\Renovasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RenovasiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Renovasi::with('user', 'nomer')->get();
    }

    public function map($renovasi) : array {
        return [
            $renovasi->id,
            $renovasi->user->name,
            $renovasi->nomer->no_rumah,
            $renovasi->tanggal_mulai,
            $renovasi->tanggal_akhir,
            strip_tags($renovasi->catatan_renovasi),
            strip_tags($renovasi->catatan_biasa),
        ] ;
    }

    public function headings(): array
    {
        return [
            'id',
            'nama user',
            'no rumah',
            'tanggal_mulai',
            'tanggal_akhir',
            'catatan_renovasi',

        ];
    }
}
