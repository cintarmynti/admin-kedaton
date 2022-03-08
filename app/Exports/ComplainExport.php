<?php

namespace App\Exports;

use App\Models\Complain;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ComplainExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Complain::with('user')->get();
    }

    public function map($complain) : array {
        return [
            $complain->id,
            $complain->user->name,
            $complain->alamat,
            $complain->status,
            strip_tags($complain->catatan),
        ] ;
    }

    public function headings(): array
    {
        return [
            'id',
            'nama user',
            'alamat',
            'status',
            'pesan_complain',

        ];
    }
}
