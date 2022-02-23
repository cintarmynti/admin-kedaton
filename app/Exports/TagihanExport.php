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

class TagihanExport implements FromView, FromCollection
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

    public function view(): View
    {
        // if($tagihan->status == 1){
        //     $status = 'belum membayar';
        // }else if($tagihan->status == 2){
        //     $status = 'pending';
        // }else{
        //     $status = 'sudah membayar';
        // }
        $tagihan = Tagihan::with('nomer', 'cluster','type')->get();

        if( $this->from){
            $tagihan->whereBetween('periode_pembayaran',[ $this->from, $this->to]);

        }

        if($this->status){
            $tagihan -> where('status', $this->status);
        }
        dd($tagihan);
        return view('pages.ipkl.excel', [
            'pembayaran' => $tagihan
        ]);
    }

    public function collection()
    {

        $query = Tagihan::with('nomer', 'cluster','type');

        if( $this->from){
            $query->whereBetween('periode_pembayaran',[ $this->from, $this->to]);

        }

        if($this->status){
            $query -> where('status', $this->status);
        }

        return $query->get();
    }

    public function map($tagihan) : array {
         if($tagihan->status == 1){
            $status = 'belum membayar';
        }else if($tagihan->status == 2){
            $status = 'pending';
        }else{
            $status = 'sudah membayar';
        }

        return [
            $tagihan->id,
            $tagihan->cluster->name,
            $tagihan->nomer->no_rumah,
            $tagihan->periode_pembayaran,
            $tagihan->jumlah_pembayaran,
            $tagihan->type->name,
            $status
            // $tagihan->status == 2  ? 'Sudah dibayar' : 'pending',
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
