<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('user_status', 'pengguna')->get();
    }

    public function map($user) : array {
        return [
            $user->name,
            $user->email,
            $user->nik,
            $user->alamat,
            $user->phone

        ] ;
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'nik',
            'alamat',
            'phone',
        ];
    }
}
