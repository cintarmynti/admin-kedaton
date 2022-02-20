<?php

namespace App\Exports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class TagihanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $from, $to;

    public function __construct(String $from, String $to, $status) {

        $this->from = $from;
        $this->to = $to;
        $this->status = $status;
    }

    public function collection()
    {

        $query = Tagihan::with('nomer', 'cluster','type');
        // dd($this->to);
        if( $this->from){
            $query->whereBetween('periode_pembayaran',[ $this->from, $this->to]);
            // return $query->get();
        }
        // dd($query->get());
        if($this->status){
            $query -> where('status', $this->status);
        }

        return $query->get();
    }

    public function map($tagihan) : array {
        return [
            $tagihan->id,
            $tagihan->cluster->name,
            $tagihan->nomer->no_rumah,
            $tagihan->periode_pembayaran,
            $tagihan->jumlah_pembayaran,
            $tagihan->type->name,
            $tagihan->status == 2  ? 'Sudah dibayar' : 'pending',
        ];
    }

    public function headings(): array
    {
        return [
           'id',
           'cluster',
           'no rumah',
            'periode pembayaran',
            'jumlah pembayaran',
            'type',
            'status tagihan'
        ];
    }
}
