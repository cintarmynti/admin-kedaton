<?php

namespace App\Exports;

use App\Models\Renovasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RenovasiExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Renovasi::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'user_id',
            'rumah_id',
            'tanggal_mulai',
            'tanggal_akhir',
            'catatan_renovasi',
            'catatan_biasa',
            'created_at',
            'updated_at'
        ];
    }
}
