<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IPKL;
use App\Models\Notifikasi;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Log;
use Illuminate\Support\Str;


class IPKLController extends Controller
{
    public function store(Request $request)
    {
        // DB::beginTransaction();
        // Log::info($request->all());

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
                // $imageName =  time() . rand(0, 2000) . '.' . 'png';
                // File::put('bukti_tf/' . $imageName, base64_decode($image));

                $image = $request->bukti_tf;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10) . '.png';

                Storage::disk('public')->put($imageName, base64_decode($image));
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
                        'bukti_tf' => 'bukti_tf/' . $imageName
                    ]);

                    Tagihan::where('id', $tagihan->id)->update([
                        'status' => 2
                    ]);
                }
            }

            $notifikasi = new Notifikasi();
            $notifikasi->user_id = $request->user_id;
            $notifikasi->sisi_notifikasi  = 'pengguna';
            $notifikasi->heading = 'Berhasil Melakukan Pembayaran IPKL';
            $notifikasi->desc = 'Terimakasih sudah melakukan pembayaran IPKL, pembayaran anda sedang di proses Admin';
            $notifikasi->save();

            $notifikasi_admin = new Notifikasi();
            $notifikasi_admin ->user_id = null;
            $notifikasi_admin ->sisi_notifikasi = 'admin';
            $notifikasi_admin -> heading = 'Pembayaran IPKL Baru';
            $notifikasi_admin ->desc = 'ada penghuni yang meakukan pembayaran';
            $notifikasi_admin ->save();

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
        $get_properti_user = Properti::where('pemilik_id', $request->user_id)->get();

        foreach($get_properti_user as $p){
            $tagihan['ipkl'] = Tagihan::with('type')->where('type_id', 1)->where('status', 1)->where('properti_id', $p->id)->get();
            $tagihan['renovasi'] = Tagihan::with('type')->where('type_id', 2)->where('status', 1)->where('properti_id', $p->id)->get();

             return ResponseFormatter::success('berhasil mendapat list tagihan yg belum dibayar!', $tagihan);
        }

    }

    public function belomDibayar(Request $request)
    {
        if (!$request->user_id) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if (User::where('id', $request->user_id)->first() == null) {
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

        $cek_properti_pemilik = Properti::where('pemilik_id', $request->user_id)->first();
        $cek_properti_penghuni = Properti::where('penghuni_id', $request->user_id)->first();
        // dd($cek_properti_pemilik );
        if ($cek_properti_pemilik != null) {
            $unpay = Tagihan::with('type')->where('properti_id', $cek_properti_pemilik->id)->where('status', 1)->where('type_id', 1)->get(['id', 'periode_pembayaran', 'jumlah_pembayaran', 'type_id']);

            // dd($unpay);

            if ($unpay->count() == 0) {
                return ResponseFormatter::failed('tidak ada tagihan IPKL yang belum dibayar!', 404);
            }
            return ResponseFormatter::success('successful to get unpaid IPKL data!', $unpay);


        } else if ($cek_properti_penghuni != null) {
            $unpay = Tagihan::with('type')->where('properti_id', $cek_properti_penghuni->id)->where('status', 1)->where('type_id', 1)->get(['id', 'periode_pembayaran', 'jumlah_pembayaran', 'type_id']);
            if ($unpay->count() == 0) {
                return ResponseFormatter::failed('tidak ada tagihan IPKL yang di acc!', 404);
            }
            return ResponseFormatter::success('successful to get unpaid IPKL data!', $unpay);
        }
        return ResponseFormatter::failed('gagal mendapat data!', 404);
    }

    public function sudahDibayar(Request $request)
    {
        if (!$request->user_id) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if (User::where('id', $request->user_id)->first() == null) {
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

        $cek_properti_pemilik = Properti::where('pemilik_id', $request->user_id)->first();
        $cek_properti_penghuni = Properti::where('penghuni_id', $request->user_id)->first();

        // dd($cek_properti_pemilik );
        if ($cek_properti_pemilik != null) {

            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_pemilik->id)->where('type_id', 1)->where('status', 3)->get();
            if ($unpay->count() == 0) {
                return ResponseFormatter::failed('tidak ada tagihan yang di acc!', 404);
            }

            return ResponseFormatter::success('successful to get paid data!', $unpay);
        } else if ($cek_properti_penghuni != null) {
            $unpay = Tagihan::with('cluster')->where('properti_id', $cek_properti_penghuni->id)->where('type_id', 1)->where('status', 3)->get();
            if ($unpay->count() == 0) {
                return ResponseFormatter::failed('tidak ada tagihan yang di acc!', 404);
            }
        }
        return ResponseFormatter::failed('gagal mendapat data!', 404);
    }

    public function ipklAcc(Request $request)
    {
        if (!$request->user_id) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if (User::where('id', $request->user_id)->first() == null) {
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

        $cek_properti_pemilik = Properti::where('pemilik_id', $request->user_id)->first();
        $cek_properti_penghuni = Properti::where('penghuni_id', $request->user_id)->first();
        // dd($cek_properti_pemilik );
        if ($cek_properti_pemilik != null) {
            $unpay = Tagihan::with([
            'ipkl' => function ($ipkl) {
                $ipkl->select('id', 'tagihan_id','periode_pembayaran', 'bank', 'bukti_tf', 'nominal');
            },
            'type' => function ($type) {
                $type->select('id','name');
            },
            'cluster' => function ($cluster) {
                $cluster->select('id','name');
            }])->where('properti_id', $cek_properti_pemilik->id)->where('status', 3)->where('type_id', 1)->get();
            if ($unpay->count() == 0) {
                return ResponseFormatter::failed('tidak ada tagihan yang sudah di bayar!', 404);
            }

            return ResponseFormatter::success('successful to get Accepted data!', $unpay);
        } else if ($cek_properti_penghuni != null) {
            $unpay = Tagihan::with([
                'ipkl' => function ($ipkl) {
                    $ipkl->select('id','periode_pembayaran', 'bank', 'bukti_tf', 'image_url');
                },
                'type' => function ($type) {
                    $type->select('id','name');
                },
                'cluster' => function ($cluster) {
                    $cluster->select('id','name');
                }
            ])->where('properti_id', $cek_properti_penghuni->id)->where('type_id', 1)->where('status', 3)->get();

            if ($unpay->count() == 0) {
                return ResponseFormatter::failed('tidak ada tagihan yang belum dibayar!', 404);
            }
            return ResponseFormatter::success('successful to get Accepted data!', $unpay);
        }
        return ResponseFormatter::failed('gagal mendapat data!', 404);
    }

    public function total_tagihan(Request $request)
    {
        if (!$request->user_id) {
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }

        if (User::where('id', $request->user_id)->first() == null) {
            return ResponseFormatter::failed('tidak ada user dengan id tersebut!', 404);
        }

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
            $total_income['lists'] = IPKL::where('user_id', $request->user_id)->where('status', 2)->whereMonth('created_at', $i)->orderBy('created_at', 'DESC')->get();

            array_push($riwayat, $total_income);
        }
        return ResponseFormatter::success('successful to get riwayat pembayaran!', $riwayat);
    }
}
