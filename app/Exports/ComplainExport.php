<?php

namespace App\Exports;

use App\Models\Complain;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ComplainExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Complain::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'user_id',
            'pesan_complain',
            'created_at',
            'updated_at'
        ];
    }
}
