<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\pembayaranMobilePulsa;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class mobilepulsaController extends Controller
{
    public function index(){
        $pembayaran = pembayaranMobilePulsa::with('user')->orderBy('id', 'desc')->get();
        return view('pages.mobile pulsa.index', [ 'bayar' => $pembayaran]);
    }

    public function getJson($id){
        $pembayaran = pembayaranMobilePulsa::find($id);
        return response()->json($pembayaran);
    }

    public function membayar(Request $request){
              $username = '087859277817';
        $bayar = Http::post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', [
            'commands' => 'pay-pasca',
            'username' => $username,
            'tr_id'    => $request->tr_id,
            'sign'     => md5($username.'54562298422ad2a7'.$request->tr_id)
        ])->json();

        if($bayar["data"]["response_code"] == 01){
            return redirect()->back()->with('failed', 'tagihan ini sudah terbayar');
        }

        $riwayat = new Riwayat();
        $riwayat->user_id = $request->user_id;
        $riwayat->harga = $request->price;
        $riwayat->type_pembayaran = $request->type;
        $riwayat->save();

        $mobilePulsa = pembayaranMobilePulsa::where('id', $request->id)->first();
        $mobilePulsa->status = 1;
        $mobilePulsa->save();

        return redirect()->back();

    }

    public function tolak(Request $request){
        $tolak = pembayaranMobilePulsa::where('id', $request->id)->first();
        // dd($tolak);
        $tolak->status = 2;
        $tolak->save();

        if($request->type == 3){
            $tipe = 'internet';
        }else if($request->type == 4){
            $tipe = 'PLN';
        }

        $notifikasi = new Notifikasi();
        $notifikasi->user_id = $request->user_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'Pembayaran'. $tipe .'anda ditolak';
        $notifikasi->desc = 'pembayaran'. $tipe. 'anda ditolak karena'.$request->alasan_penolakan;
        $notifikasi->save();

        return redirect()->back();

    }
}
