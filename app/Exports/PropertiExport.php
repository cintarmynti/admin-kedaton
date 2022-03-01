<?php

namespace App\Exports;

use App\Models\Properti;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;


class PropertiExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('pages.properti.excel', [
            'properti' => Properti::with('penghuni', 'pemilik', 'cluster')->get()
        ]);
    }

    public function collection()
    {
        return Properti::with('penghuni', 'pemilik', 'cluster')->get();
    }

    public function map($properti) : array {
        return [
            $properti->pemilik->name,
            $properti->cluster->name,
            $properti->no_rumah,
            $properti->no_listrik,
            $properti->no_pam_bsd,
            isset($properti->penghuni->name) ? $properti->penghuni->name : 'Tidak ada nama',
            $properti->alamat,
            $properti->RT,
            $properti->RW,
            $properti->lantai,
            $properti->jumlah_kamar,
            $properti->luas_tanah,
            $properti->luas_bangunan,
            $properti->tarif_ipkl,
            $properti->status,

        ] ;
    }

    public function headings(): array
    {
        return [
            'pemilik',
            'cluster',
            'no rumah',
            'no listrik',
            'no pam bsd',
            'penghuni',
            'alamat',
            'RT',
            'RW',
            'jumlah lantai',
            'jumlah kamar',
           'luas_tanah',
           'luas_bangunan',
           'tarif_ipkl',
           'status',
        ];
    }
}
