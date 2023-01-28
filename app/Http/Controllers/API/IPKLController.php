<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Lib\PusherFactory;
use App\Models\IPKL;
use App\Models\Notifikasi;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Properti;
use App\Models\Riwayat;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Log;
use Illuminate\Support\Str;
use Kutia\Larafirebase\Facades\Larafirebase;

class IPKLController extends Controller
{
    public function store(Request $request)
    {


        if (!$request->user_id || !$request->tagihan_id || !$request->bank || !$request->bukti_tf) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if (User::where('id', $request->user_id)->first() == null) {
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

        try {
            $ipkl = [];
            if ($request->bukti_tf) {

                // $image = $request->bukti_tf;  // your base64 encoded
                // $image = str_replace('data:image/png;base64,', '', $image);
                // $image = str_replace(' ', '+', $image);
                // $imageName = 'bukti_tf/'.Str::random(10) . '.png';

                // Storage::disk('public')->put($imageName, base64_decode($image));

                if ($request->bukti_tf) {
                    $data = substr($request->bukti_tf, strpos($request->bukti_tf, ',') + 1);
                    $data = base64_decode($data);

                    $fileName = Str::random(10) . '.png';
                    Storage::put('bukti_tf/' . $fileName, $data);

                    $url = 'storage/bukti_tf/' . $fileName;
                    $image = Image::make($url);
                    $image->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });


                    Storage::put('bukti_tf/' . $fileName, (string) $image->encode());
                    // dd($fileName);
                    $image_path = 'bukti_tf/' . $fileName;


                }
            }
            foreach ($request->tagihan_id as $i) {
                //cek gagal
                $id_tagihan = Tagihan::where('id', $i)->first();
                $pembayaran_id = IPKL::where('tagihan_id', $i)->first();
                // dd($pembayaran_id);
                if ($id_tagihan == null) {
                    return ResponseFormatter::failed('tagihan id dengan user ini tidak ada!', 404);
                } else if ($pembayaran_id != null) {
                    return ResponseFormatter::failed('tagihan telah dibayar!', 404);
                }
                $tagihan = Tagihan::find($i);

                if ($tagihan) {
                    $ipkl[] = IPKL::create([
                        'user_id' => $request->user_id,
                        'bank' => $request->bank,
                        'tagihan_id' => $tagihan->id,
                        'nominal' => $tagihan->jumlah_pembayaran,
                        'status' => 1,
                        'periode_pembayaran' => Carbon::now(),
                        'type' => $tagihan->type_id,
                        'bukti_tf' =>$image_path
                    ]);

                    Tagihan::where('id', $tagihan->id)->update([
                        'status' => 2
                    ]);
                }
            }

            $notifikasi = new Notifikasi();
            $notifikasi->type = 1;
            $notifikasi->user_id = $request->user_id;
            $notifikasi->sisi_notifikasi  = 'pengguna';
            $notifikasi->heading = 'BERHASIL MELAKUKAN PEMBAYARAN IPKL';
            $notifikasi->desc = 'Terimakasih sudah melakukan pembayaran IPKL, pembayaran anda sedang di proses Admin';
            $notifikasi->save();

            // $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            $fcmTokens = User::where('id', $request->user_id)->first()->fcm_token;
            // dd($fcmTokens);
             larafirebase::withTitle('BERHASIL MELAKUKAN PEMBAYARAN IPKL')
            ->withBody('Terimakasih sudah melakukan pembayaran IPKL, pembayaran anda sedang di proses Admin')
            // ->withImage('https://firebase.google.com/images/social.png')
            ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
            ->withClickAction('admin/notifications')
            ->withPriority('high')
            ->withAdditionalData([
                'halo' => 'isinya',
            ])
            ->sendNotification($fcmTokens);

            $notifikasi_admin = new Notifikasi();
            $notifikasi_admin ->user_id = null;
            $notifikasi_admin ->sisi_notifikasi = 'admin';
            $notifikasi_admin -> heading = 'PEMBAYARAN IPKL BARU';
            $notifikasi_admin ->desc = 'ada penghuni yang melakukan pembayaran';
            $notifikasi_admin -> link = '/ipkl/pembayaran/'.$request->user_id;
            $notifikasi_admin ->save();

            PusherFactory::make()->trigger('admin', 'kirim', ['data' => $notifikasi_admin]);


            // DB::commit();
            return ResponseFormatter::success('successful to pay !', $ipkl);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return ResponseFormatter::failed('gagal pay data!', 404);
        }
    }


    public function listTagihan(Request $request)
    {

        if (!$request->user_id) {
            return ResponseFormatter::failed('tidak ada list tagihan pada user_id ini!', 404);
        }

        $user = User::where('id', $request->user_id)->first();

        if ($user == null) {
            return ResponseFormatter::failed('tidak ada user dengan id ini!', 404);
        }

        $properti = Properti::where('pemilik_id', $request->user_id)->orWhere('penghuni_id', $request->user_id)->get();
        if ($properti->count() == 0) {
            $tagihan['ipkl'] = '';
            $tagihan['renovasi'] = '';
            return ResponseFormatter::success('tidak ada tagihan!', $tagihan);
        }

        $array_ipkl = [];
        $array_renovasi = [];
        foreach ($properti as $p) {
            $push_ipkl = Tagihan::with('type')->where('type_id', 1)->where('status', 1)->where('properti_id', $p->id)->select('id', 'type_id', 'jumlah_pembayaran', 'properti_id', 'periode_pembayaran')->get();
            foreach ($push_ipkl as $key => $ipkl) {
                array_push($array_ipkl, $ipkl);
            }
            $push_renovasi = Tagihan::with('type')->where('type_id', 2)->where('status', 1)->where('properti_id', $p->id)->get();
            foreach ($push_renovasi as $key => $renovasi) {
                array_push($array_renovasi, $renovasi);
            }
        }

        $tagihan['ipkl'] = $array_ipkl;
        $tagihan['renovasi'] = $array_renovasi;
        return ResponseFormatter::success('berhasil mendapat list tagihan yg belum dibayar!', $tagihan);
    }

    public function belomDibayar(Request $request)
    {
        if (!$request->user_id) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if (User::where('id', $request->user_id)->first() == null) {
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

        $properti = Properti::where('pemilik_id', $request->user_id)->orWhere('penghuni_id', $request->user_id)->get();
        if($properti->count() == 0){
            return ResponseFormatter::failed('user belum meiliki properti!', 404);
        }


        $array_unpay = [];
        foreach($properti as $p){
            $push_unpay = Tagihan::with('type', 'cluster', 'nomer')->where('properti_id', $p->id)->where('status', 1)->where('type_id', 1)->get(['id', 'periode_pembayaran', 'jumlah_pembayaran', 'type_id', 'properti_id', 'cluster_id']);

            foreach($push_unpay as $key => $unpay){
                array_push($array_unpay, $unpay);
            }

        }

        return ResponseFormatter::success('berhasil mendapat ipkl belum dibayar!', $array_unpay);

    }



    public function sudahBayarIpkl(Request $request)
    {
        if (!$request->user_id) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if (User::where('id', $request->user_id)->first() == null) {
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

        $properti = Properti::where('pemilik_id', $request->user_id)->orWhere('penghuni_id', $request->user_id)->get();
        if($properti->count() == 0){
            return ResponseFormatter::failed('user belum memiliki tagihan IPKL !', 404);
        }

        $array_dibayar = [];
        foreach($properti as $p){
            $push_dibayar = Tagihan::with([
                    'ipkl' => function ($ipkl) {
                        $ipkl->select('id', 'tagihan_id','periode_pembayaran', 'bank', 'bukti_tf', 'nominal');
                    },
                    'type' => function($type){
                        $type->select('id','name', 'desc');
                    }])
                    ->where('properti_id', $p->id)->where('status', 3)->where('type_id', 1)->get();
            foreach($push_dibayar as $key => $dibayar){
                array_push($array_dibayar, $dibayar);
            }

        }

        return ResponseFormatter::success('successful to get Accepted data!', $array_dibayar);

    }

    public function total_tagihan(Request $request)
    {
        if (!$request->user_id) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if (User::where('id', $request->user_id)->first() == null) {
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

        $properti = Properti::where('pemilik_id', $request->user_id)->orWhere('penghuni_id', $request->user_id)->get();

        if($properti->count() == 0){
            return ResponseFormatter::failed('user belum meiliki properti !', 404);
        }


        $array_total = [];
        foreach($properti as $p){

            $push_total = Tagihan::with('cluster')->where('properti_id', $p->id)->where('status', 1)->get();
            foreach($push_total as $key => $total){
                array_push($array_total, $total->jumlah_pembayaran);
            }
        }
        return ResponseFormatter::success('successful to get total pembayaran!', array_sum($array_total));


    }

    public function riwayat_bayar(Request $request)
    {
        if(!$request->user_id){
            return ResponseFormatter::failed('data tidak boleh kosong!', 404);
        }

        $total_riwayat = IPKL::where('user_id', $request->user_id)->where('status', 2)->get();
        if($total_riwayat->count() == 0){
            return ResponseFormatter::failed('tidak ada riwayat pembayaran!', 404);
        }
        $riwayat = [];

        $data = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        for ($i = 1; $i <= 12; $i++) {
            $total_income['month'] = $data[$i - 1];
            $total_income['lists'] = IPKL::with('type')->where('user_id', $request->user_id)->where('status', 2)->whereMonth('periode_pembayaran', $i)->orderBy('created_at', 'DESC')->get();

            if($total_income['lists']->count() != 0){
                array_push($riwayat, $total_income);
            }

        }
        return ResponseFormatter::success('successful to get riwayat pembayaran!', $riwayat);
    }

    public function detailIpkl(Request $request){
        if(!$request->tagihan_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }
        $tagihan = Tagihan::where('id', $request->tagihan_id)->with('ipkl')->first();
        return ResponseFormatter::success('berhasil mendapat detail tagihan!', $tagihan);
    }

    //Tagihan belum fiks
    public function tagihan(Request $request){

        if (!$request->user_id) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if($request->jenis == 'card'){

            $properti = DB::table('properti')
                        ->Join('tagihan', 'properti.id', '=', 'tagihan.properti_id')
                        ->Join('properti_images', 'properti.id', '=', 'properti_images.id')
                        ->leftJoin('users as usr', 'properti.pemilik_id', '=', 'usr.id')
                        ->leftJoin('users as us', 'properti.penghuni_id', '=', 'us.id')
                        ->Join('cluster', 'properti.cluster_id', '=', 'cluster.id')
                        ->where('tagihan.status', 1)
                        ->where('penghuni_id', $request->user_id)
                        ->orWhere('pemilik_id', $request->user_id)
                        ->groupBy('tagihan.properti_id')
                        ->selectRaw('sum(jumlah_pembayaran) as sum, tagihan.properti_id,image,cluster.name,no_rumah, usr.name as pemilik, us.name as penghuni')
                        ->get();

            // dd($properti);

            foreach ($properti as $q) {
                $q->gambar =  url('/').'/storage/'.$q->image;

            }

            return ResponseFormatter::success('berhasil mendapat detail tagihan!', $properti);
        }else if($request->jenis == 'riwayat'){
            $properti = Properti::where('pemilik_id', $request->user_id)->orWhere('penghuni_id', $request->user_id)->get();
            // dd($properti);
            $myArr = [];
            foreach($properti as $p){
                $tagihan = riwayat::with(['type' => function ($query) {
                    $query->select('id', 'name');
                }, 'nomer' => function($query){
                    $query->select('id', 'no_rumah');
                }])->where('properti_id', $p->id)->limit(2)->get();


                foreach($tagihan as $t){
                    array_push($myArr, $t);
                }
                // dd(8$tagihan);
            }
            return ResponseFormatter::success('berhasil riwayat tagihan!', $myArr);
        }else if($request-> jenis = 'jumlah'){
            if (!$request->user_id) {
                return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
            }

            if (User::where('id', $request->user_id)->first() == null) {
                return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
            }

            $properti = Properti::where('pemilik_id', $request->user_id)->orWhere('penghuni_id', $request->user_id)->get();

            if($properti->count() == 0){
                return ResponseFormatter::failed('user belum meiliki properti !', 404);
            }


            $array_total = [];
            foreach($properti as $p){

                $push_total = Tagihan::with('cluster')->where('properti_id', $p->id)->where('status', 1)->get();
                foreach($push_total as $key => $total){
                    array_push($array_total, $total->jumlah_pembayaran);
                }
            }
            return ResponseFormatter::success('successful to get total pembayaran!', array_sum($array_total));
        }

    }

    public function detailPembayaran(Request $request){
        if($request->status = 'terbayar'){
            //terbayar
            $ipkl = tagihan::with('type', 'cluster', 'nomer')->where('status', 3)->orderBy('id', 'desc')->get();
            return ResponseFormatter::success('berhasil mengambil tagihan yg terbayar!', $ipkl);
        }else if($request->status = 'menunggu'){
            //belum bayar
            $ipkl = tagihan::with('type', 'cluster', 'nomer')->where('status', 1)->orderBy('id', 'desc')->get();
            return ResponseFormatter::success('berhasil tagihan yg belum terbayar!', $ipkl);
        }else if($request->status = 'gagal'){
            //gagal
            $ipkl = tagihan::with('type', 'cluster', 'nomer')->where('status', 4)->orderBy('id', 'desc')->get();
            return ResponseFormatter::success('berhasil mengambil tagihan yg gagal!', $ipkl);
        }

    }

    public function detailTagihan(Request $request){
        // if (!$request->user_id) {
        //     return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        // }

        // if (User::where('id', $request->user_id)->first() == null) {
        //     return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        // }

        $properti = Properti::where('id', $request->properti_id)->first();
        if($properti == null){
            return ResponseFormatter::failed('tidak ada properti!', 404);
        }



            $riwayat = [];
            $data = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            for ($i = 1; $i <= 12; $i++) {
                $total_income['month'] = $data[$i - 1];
                $total_income['lists'] = Tagihan::with(
                ['type' => function ($query) {
                    $query->select('id', 'name');
                }, 'nomer' => function($query){
                    $query->select('id', 'no_rumah');
                }, 'cluster' => function($query){
                    $query->select('id', 'name');
                }])->where('properti_id', $properti->id)->where('status', 1)->whereMonth('periode_pembayaran', $i)->where('type_id', 1)->get(['tanggal_ditagihkan', 'bulan_thn', 'type_id', 'properti_id', 'cluster_id', 'tanggal_ditagihkan']);

                if($total_income['lists']->count() != 0){
                    array_push($riwayat, $total_income);
                }

            }

        return ResponseFormatter::success('berhasil mendapat ipkl belum dibayar!', $riwayat);
    }
}
