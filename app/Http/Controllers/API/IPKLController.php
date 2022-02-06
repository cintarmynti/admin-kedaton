<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IPKL;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class IPKLController extends Controller
{
    public function store(Request $request){
        $ipkl = new IPKL();
        $ipkl -> user_id = $request->user_id;
        $ipkl->tagihan_id = $request->tagihan_id;
        $ipkl->periode_pembayaran = Carbon::now()->toDateString();
        $ipkl->bank = $request->bank;
        $ipkl->nominal = $request->nominal;
        $ipkl->status = 1;

        if($request->hasFile('bukti_tf'))
        {
            $file = $request->file('bukti_tf');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('bukti_tf',$filename);
            $ipkl->bukti_tf=$filename;
        }
        $ipkl->save();

        return ResponseFormatter::success('successful payment!', $ipkl);

    }

    public function belomDibayar(Request $request){
        $unpay = Tagihan::where('listing_id', $request->no_rumah_id)->where('status', 1)->get();
        return ResponseFormatter::success('successful to get unpaid data!', $unpay);

    }

    public function sudahDibayar(Request $request){
        $unpay = Tagihan::where('listing_id', $request->no_rumah_id)->where('status', 2)->get();
        return ResponseFormatter::success('successful to get paid data!', $unpay);
    }

    public function ipklAcc(Request $request)
    {

        $riwayat_pembayaran = Tagihan::where('listing_id', $request->no_rumah_id)->where('status', 2)->get();
        return ResponseFormatter::success('successful to get IPKL accepted by user!', $riwayat_pembayaran);

    }


}
