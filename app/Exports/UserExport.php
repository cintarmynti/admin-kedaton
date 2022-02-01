<?php

namespace App\Exports;

use App\Models\user;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return user::where('user_status', 'pengguna')->get();
    }

    public function headings(): array
    {
        return [
            'nama pengguna',
            'NIK',
            'ALAMAT',
            'NO TELP',
            'DETAIL PHOTO'
        ];
    }

}
