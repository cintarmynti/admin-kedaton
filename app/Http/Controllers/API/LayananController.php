<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\layanan;
use App\Models\pengajuan_layanan;

class LayananController extends Controller
{
    public function pengajuan(Request $request)
    {
        $cek_layanan = layanan::where('id', $request->layanan_id)->first();
        $cek_pengajuan_user = pengajuan_layanan::where('tanggal', $request->tanggal)->where('user_id', $request->user_id)->first();

        if($cek_layanan == null){
            return ResponseFormatter::failed('layanan_id yang dimasukkan tidak ada!', 404);
        }else if($cek_pengajuan_user != null){
            return ResponseFormatter::failed('anda sudah melakukan pengajuan, tunggu persetujuan admin!', 404);
        }
        $layanan= pengajuan_layanan::create([
            'layanan_id'  => $request->layanan_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'user_id' => $request->user_id,
            'status' => 'diajukan',
            'catatan' => $request->catatan
        ]);
        
        if($layanan){
            return ResponseFormatter::success('berhasil melakukan pengajuan !', $layanan);
        }else{
            return ResponseFormatter::failed('gagal melakukann pengajuan!', 404);
        }
    }

    public function ambilLayanan(Request $request)
    {

        $cek_user = pengajuan_layanan::where('user_id', $request->user_id)->get();
        // dd($cek_user);
        if($cek_user == null){
            return ResponseFormatter::failed('user ini belum melakukan pengajuan layanan apapun!', 404);
        }
        if($request->status){
            $diproses = pengajuan_layanan::where('status', $request->status)->where('user_id', $request->user_id)->get();
            return ResponseFormatter::success('berhasil mengambil layanan yang difilter!', $diproses);
        }else{
            $diproses = pengajuan_layanan::where('user_id', $request->user_id)->get();
            return ResponseFormatter::success('berhasil mengambil semua layanan!', $diproses);
        }
        return ResponseFormatter::failed('gagal mengambil data!', 404);



    }

    public function daftarLayanan(Request $request){
        $daftar_layanan = Layanan::all();
        return ResponseFormatter::success('berhasil mengambil semua layanan!', $daftar_layanan);

    }
}
