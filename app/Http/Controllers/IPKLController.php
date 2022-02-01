<?php

namespace App\Http\Controllers;

use App\Models\IPKL;
use App\Models\Listing;
use Illuminate\Http\Request;

class IPKLController extends Controller
{
    public function index()
    {
        $ipkl = IPKL::with('nomer')->get();
        return view('pages.ipkl.index', ['ipkl' => $ipkl]);
    }

    public function create()
    {
        $nomer = Listing::all();
        return view('pages.ipkl.create', ['nomer' => $nomer]);
    }

    public function store(Request $request)
    {
        $ipkl = new IPKL();
        $ipkl-> rumah_id = $request->rumah_id;
        $ipkl->periode_pembayaran = $request->periode_pembayaran;
        $ipkl->metode_pembayaran = $request->metode_pembayaran;
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
}
