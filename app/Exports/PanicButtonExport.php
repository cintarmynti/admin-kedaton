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

    public function __construct(String $from, String $to, $status) {

        $this->from = $from;
        $this->to = $to;
        $this->status = $status;
    }

    public function collection()
    {

        $query = PanicButton::with('user', 'properti');
        // dd($this->to);
        if( $this->from){
            $query->whereBetween('created_at',[ $this->from, $this->to]);
            // return $query->get();
        }
        // dd($query->get());
        if($this->status){
            $query -> where('status_keterangan', $this->status);
        }
        // dd($query->get());
        return $query->get();
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
