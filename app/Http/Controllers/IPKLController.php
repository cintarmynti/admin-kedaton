<?php

namespace App\Http\Controllers;

use App\Exports\TagihanExport;
use App\Models\IPKL;
use App\Models\Cluster;
use App\Models\Listing;
use App\Models\Notifikasi;
use App\Models\Properti;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use App\Models\Rumah;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class IPKLController extends Controller
{
    public function index(Request $request)
    {
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $query = Tagihan::with('nomer', 'cluster')->orderby('created_at', 'desc');
        // dd($start_date);

        if($request -> start_date){
            $query->whereBetween('periode_pembayaran',[$start_date,$end_date]);
        }

        if($request -> status){
            $query -> where('status', $request->status);
        }

        return view('pages.ipkl.index', ['ipkl' => $query->get()]);
    }

    public function getIPKLid($id)
    {
        $listing = Properti::where('cluster_id', $id)->get();
        $html   = '';
        foreach($listing as $data){
            $html .= '<option value="'.$data['id'].'">'.$data['no_rumah'].'</option>';
        }
        echo $html;
        // return response()->json($Listing);
    }

    public function getIPKLharga($id)
    {
        $listing = Properti::findOrFail($id);
        $html   = '';
        $html .= $listing['tarif_ipkl'];
        echo $html;
        // return response()->json($Listing);
    }

    public function export_excel(Request $request){
        if(!$request->start_date){
            $from = '';
        }else{
            $from = Carbon::parse($request->start_date);
        }

        if(!$request->end_date){
            $to = '';
        }else{
            $to = Carbon::parse($request->end_date);
        }
        $status = $request->status;

        return Excel::download(new TagihanExport($from, $to, $status), 'Tagihan.xlsx');
    }

    public function create()
    {
        $nomer = Properti::all();
        $cluster = Cluster::all();
        return view('pages.ipkl.create', ['nomer' => $nomer, 'cluster' => $cluster]);
    }

    public function store(Request $request)
    {
        $cekTagihan = Tagihan::whereMonth('periode_pembayaran', Carbon::parse($request->periode_pembayaran))->first();
        if($cekTagihan != null){
            return redirect()->back()->withErrors(['msg' => 'tagihan properti untuk periode tersebut sudah ada']);
        }
        $ipkl = new Tagihan();
        $ipkl-> cluster_id = $request->cluster_id;
        $ipkl-> properti_id = $request->properti_id;
        $ipkl->periode_pembayaran = $request->periode_pembayaran;
        $ipkl->jumlah_pembayaran = $request->jumlah_pembayaran;
        $ipkl->status = 1;
        $ipkl->type_id = 1;
        $ipkl->save();

        return redirect('/ipkl');
    }

    public function edit($id)
    {
        $ipkl = IPKL::findOrFail($id);
        return view('pages.ipkl.edit', ['ipkl' => $ipkl]);
    }

    public function update(Request $request, $id)
    {
        $ipkl = IPKL::findOrFail($id);
        $ipkl-> rumah_id = $request->rumah_id;
        $ipkl->metode_pembayaran = $request->metode_pembayaran;
        $ipkl->periode_pembayaran = $request->periode_pembayaran;
        $ipkl->jumlah_pembayaran = $request->jumlah_pembayaran;
        $ipkl->status = $request->status;
        $ipkl->update();

        return redirect('/ipkl');
    }

    public function status($id)
    {
        $data = IPKL::findOrFail($id);
        // dd($status_id);
        $status_sekarang = $data->status;
        if($status_sekarang == 1){
            IPKL::where('id', $id)->update([
                'status' => 2
            ]);
        }
        return redirect('/ipkl');
    }

    public function delete($id)
    {
        $ipkl = IPKL::findOrFail($id);
        $ipkl->delete();
        return redirect('/ipkl');
    }

    public function get_riwayat($id){

        $cancel = IPKL::findOrFail($id);
        return response()->json($cancel);
     }

     public function create_riwayat(Request $request)
     {
        // dd($request->all());

        $riwayat = new Notifikasi();
        $riwayat -> user_id = $request->user_id;
        $riwayat-> pembayaran_id = $request->pembayaran_id;
        $riwayat->tanggal = Carbon::now()->toDateString();
        $riwayat-> desc = 'pembayaran anda telah diterima oleh admin';
        $riwayat->type = 'IPKL';
        $riwayat->save();
        Alert::success('Data berhasil disimpan');

        $data = IPKL::findOrFail($request-> pembayaran_id);
        // dd($status_id);
        $status_sekarang = $data->status;
        if($status_sekarang == 1){
            IPKL::where('id', $request-> pembayaran_id)->update([
                'status' => 2
            ]);
            Tagihan::where('id', $request->tagihan_id)->update([
                'status' => 3
            ]);
        }
        return redirect('/ipkl');
        // return redirect('/ipkl');
     }

     public function pembayar($id){
        $ipkl = IPKL::with('user')->where('tagihan_id', $id)->get();
        return view('pages.ipkl.detail', ['ipkl' => $ipkl]);
     }
}
