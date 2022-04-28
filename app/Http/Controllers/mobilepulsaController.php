<?php

namespace App\Http\Controllers;
use Kutia\Larafirebase\Facades\Larafirebase;
use App\Models\Notifikasi;
use App\Models\pembayaranMobilePulsa;
use App\Models\Riwayat;
use App\Models\User;
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

        if($request->type == 3){
            $tipe_notif = 6;
        }else if($request->type == 4){
            $tipe_notif = 5;
        }

        if($request->type == 3){
            $tipe = 'internet';
        }else if($request->type == 4){
            $tipe = 'PLN';
        }

        $notifikasi = new Notifikasi();
        $notifikasi->type = $tipe_notif;
        $notifikasi->user_id = $request->user_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'PEMBAYARAN '. $tipe.' TELAH DISETUJUI';
        $notifikasi->desc = 'Pembayaran '. $tipe.' telah disetujui admin, terimakasih sudah membayar';
        $notifikasi->save();


        $fcmTokens = User::where('id', $request->user_id)->first()->fcm_token;
        // $fcmTokens = User::where('id', 29)->first()->fcm_token;
        // dd($fcmTokens);
        larafirebase::withTitle('PEMBAYARAN '. $tipe.' TELAH DISETUJUI')
        ->withBody('Pembayaran '. $tipe.' telah disetujui admin, terimakasih sudah membayar')
        // ->withImage('https://firebase.google.com/images/social.png')
        ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
        ->withClickAction('admin/notifications')
        ->withPriority('high')
        ->withAdditionalData([
            'halo' => 'isinya',
        ])
    ->sendNotification($fcmTokens);


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

        if($request->type == 3){
            $tipe_notif = 6;
        }else if($request->type == 4){
            $tipe_notif = 5;
        }

        $notifikasi = new Notifikasi();
        $notifikasi->type = $tipe_notif;
        $notifikasi->user_id = $request->user_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'PEMBAYARAN'. $tipe .'ANDA DITOLAK';
        $notifikasi->desc = 'pembayaran '. $tipe. ' anda ditolak karena '.$request->alasan_penolakan;
        $notifikasi->save();

        $fcmTokens = User::where('id', $request->user_id)->first()->fcm_token;
        // $fcmTokens = User::where('id', 29)->first()->fcm_token;
        // dd($fcmTokens);
        larafirebase::withTitle('PEMBAYARAN'. $tipe .'ANDA DITOLAK')
        ->withBody('pembayaran '. $tipe. ' anda ditolak karena '.$request->alasan_penolakan)
        // ->withImage('https://firebase.google.com/images/social.png')
        ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
        ->withClickAction('admin/notifications')
        ->withPriority('high')
        ->withAdditionalData([
            'halo' => 'isinya',
        ])
    ->sendNotification($fcmTokens);

        return redirect()->back();

    }
}
