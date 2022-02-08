<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IPKL;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Properti;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Log;

class IPKLController extends Controller
{
    public function store(Request $request)
    {
        // DB::beginTransaction();
        // Log::info($request->all());
        try {
            $ipkl = [];
            if ($request->bukti_tf) {
                $image = $request->bukti_tf;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName =  time().rand(0,2000).'.'.'png';
                File::put('bukti_tf/' . $imageName, base64_decode($image));
            }
            foreach ($request->tagihan_id as $i) {
                $tagihan = Tagihan::find($i);
                if($tagihan){
                    $ipkl[] = IPKL::create([
                        'user_id' => $request->user_id,
                        'bank' => $request->bank,
                        'tagihan_id' => $tagihan->id,
                        'nominal' => $tagihan->jumlah_pembayaran,
                        'status' => 1,
                        'periode_pembayaran' => Carbon::now(),
                        'bukti_tf' => $imageName
                    ]);
                }
            }

            // DB::commit();
            return ResponseFormatter::success('successful to pay !', $ipkl);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return ResponseFormatter::failed('gagal pay data!', 404);
        }


    }

    public function belomDibayar(Request $request)
    {
        $cek_properti_pemilik = Properti::where('pemilik_id', $request->user_id)->first();
        $cek_properti_penghuni = Properti::where('penghuni_id', $request->user_id)->first();
        // dd($cek_properti_pemilik );
        if ($cek_properti_pemilik != null) {
            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_pemilik->id)->where('status', 1)->get();
            return ResponseFormatter::success('successful to get unpaid data!', $unpay);
        } else if ($cek_properti_penghuni != null) {
            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_penghuni->id)->where('status', 1)->get();
            return ResponseFormatter::success('successful to get unpaid data!', $unpay);
        }
        return ResponseFormatter::failed('gagal mendapat data!', 404);
    }

    public function sudahDibayar(Request $request)
    {
        $cek_properti_pemilik = Properti::where('pemilik_id', $request->user_id)->first();
        $cek_properti_penghuni = Properti::where('penghuni_id', $request->user_id)->first();
        // dd($cek_properti_pemilik );
        if ($cek_properti_pemilik != null) {
            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_pemilik->id)->where('status', 2)->get();
            return ResponseFormatter::success('successful to get paid data!', $unpay);
        } else if ($cek_properti_penghuni != null) {
            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_penghuni->id)->where('status', 2)->get();
            return ResponseFormatter::success('successful to get paid data!', $unpay);
        }
        return ResponseFormatter::failed('gagal mendapat data!', 404);
    }

    public function ipklAcc(Request $request)
    {
        $cek_properti_pemilik = Properti::where('pemilik_id', $request->user_id)->first();
        $cek_properti_penghuni = Properti::where('penghuni_id', $request->user_id)->first();
        // dd($cek_properti_pemilik );
        if ($cek_properti_pemilik != null) {
            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_pemilik->id)->where('status', 2)->get();
            return ResponseFormatter::success('successful to get Accepted data!', $unpay);
        } else if ($cek_properti_penghuni != null) {
            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_penghuni->id)->where('status', 2)->get();
            return ResponseFormatter::success('successful to get Accepted data!', $unpay);
        }
        return ResponseFormatter::failed('gagal mendapat data!', 404);
    }

    public function total_tagihan(Request $request)
    {
        $cek_properti_pemilik = Properti::where('pemilik_id', $request->user_id)->first();
        $cek_properti_penghuni = Properti::where('penghuni_id', $request->user_id)->first();
        // dd($cek_properti_pemilik );
        if ($cek_properti_pemilik != null) {
            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_pemilik->id)->where('status', 1)->get()->sum('jumlah_pembayaran');

            return ResponseFormatter::success('successful to get total pembayaran!', $unpay);
        } else if ($cek_properti_penghuni != null) {
            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_pemilik->id)->where('status', 1)->get()->sum('jumlah_pembayaran');
            return ResponseFormatter::success('successful to get total pembayaran!', $unpay);
        }
        return ResponseFormatter::failed('gagal mendapat data!', 404);
    }

    public function riwayat_bayar(Request $request)
    {

        $riwayat = [];

        $data= ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        for ($i=1; $i <= 12 ; $i++) {
            $total_income['month'] = $data[$i-1];
            $total_income['lists'] = IPKL::where('user_id', $request->user_id)->where('status', 2)->whereMonth('created_at', $i)->orderBy('created_at','DESC')->get();

            array_push($riwayat, $total_income);

        }
        return ResponseFormatter::success('successful to get riwayat pembayaran!', $riwayat);

    }
}
