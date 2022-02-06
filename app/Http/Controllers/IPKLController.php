<?php

namespace App\Http\Controllers;

use App\Models\IPKL;
use App\Models\Cluster;
use App\Models\Listing;
use App\Models\Notifikasi;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use App\Models\Rumah;

class IPKLController extends Controller
{
    public function index()
    {
        $ipkl = Tagihan::with('nomer', 'cluster')->get();
        // dd($ipkl);
        return view('pages.ipkl.index', ['ipkl' => $ipkl]);
    }

    public function getIPKLid($id)
    {
        $listing = Listing::where('cluster_id', $id)->get();
        $html   = '';
        foreach($listing as $data){

            $html .= '<option value="'.$data['id'].'">'.$data['no_rumah'].'</option>';
        }

        echo $html;
        // return response()->json($Listing);
    }

    public function getIPKLharga($id)
    {
        $listing = Listing::findOrFail($id);
        $html   = '';
        $html .= $listing['tarif_ipkl'];
        echo $html;
        // return response()->json($Listing);
    }



    public function create()
    {
        $nomer = Listing::all();
        $cluster = Cluster::all();
        return view('pages.ipkl.create', ['nomer' => $nomer, 'cluster' => $cluster]);
    }

    public function store(Request $request)
    {
        $ipkl = new Tagihan();
        $ipkl-> cluster_id = $request->cluster_id;
        $ipkl-> listing_id = $request->rumah_id;
        $ipkl->periode_pembayaran = $request->periode_pembayaran;
        $ipkl->jumlah_pembayaran = $request->jumlah_pembayaran;
        $ipkl->status = 1;
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

        return redirect('ipkl');
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
                'status' => 2
            ]);
        }

        return redirect()->back();
        // return redirect('/ipkl');
     }

     public function pembayar($id){
        $ipkl = IPKL::with('user')->where('tagihan_id', $id)->get();
        return view('pages.ipkl.detail', ['ipkl' => $ipkl]);
     }
}
