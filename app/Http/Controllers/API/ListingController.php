<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\rev_listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\ResponseFormatter;


class ListingController extends Controller
{
    // ini yang udah di revisi
    public function getProperti(Request $request){
        $cek_user = rev_listing::where('status', $request->status)->get();
        // dd($cek_user);
        if($cek_user == null){
            return ResponseFormatter::failed('tidak ada properti dengan status ini!', 404);
        }

        if($request->status){
            $diproses = rev_listing::where('status', $request->status)->orderBy('created_at', 'desc')->get();
            return ResponseFormatter::success('berhasil mengambil properti yang difilter berdasarkan input!', $diproses);
        }else if($request->name){
            $cari = rev_listing::where('name','like', "%". $request->name . "%")->get();
            // dd($cari);
            return ResponseFormatter::success('berhasil mendapatkan yang dicari!', $cari);
        }else{
            $diproses = rev_listing::orderBy('created_at', 'desc')->get();
            $promo = rev_listing::whereNotNull('diskon')->get();
            return ResponseFormatter::success('berhasil mengambil semua properti!', [$diproses, $promo]);
        }

        return ResponseFormatter::failed('gagal mengambil properti!', 404);
    }


    public function createImage(Request $request){
        $image = $request->properti_image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName =  time().rand(0,2000).'.'.'png';
        File::put('properti_photo/' . $imageName, base64_decode($image));

        return ResponseFormatter::success('berhasil mengembil mengirim gambar!', $imageName);
    }


}
