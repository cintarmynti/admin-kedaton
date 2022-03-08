<?php

namespace App\Exports;

use App\Models\Complain;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromView;


class ComplainExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Complain::with('user')->get();
    // }

    protected $from, $to;

    public function __construct(String $from, String $to, $status) {

        $this->from = $from;
        $this->to = $to;
        $this->status = $status;
    }

    public function view(): View
    {
        $complain = Complain::with('user');

        if( $this->from){
            $complain->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
        }

        if($this->status){
            $complain -> where('status', $this->status);
        }

        // dd($complain);
        return view('pages.laporan complain.excel', ['complain' => $complain->get()]);
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
