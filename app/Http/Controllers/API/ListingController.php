<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\rev_listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\ResponseFormatter;


class ListingController extends Controller
{
    // public function create_listing(Request $request){
    //     $layanan= pengajuan_layanan::create([
    //         'layanan_id'  => $request->layanan_id,
    //         'tanggal' => $request->tanggal,
    //         'jam' => $request->jam,
    //         'user_id' => $request->user_id,
    //         'status' => 'diajukan',
    //         'catatan' => $request->catatan
    //     ]);
    // }

    public function getProperti(){
        $listing = rev_listing::all();
        if($listing){
            return ResponseFormatter::success('berhasil mengembil semua properti!', $listing);
        }else{
            return ResponseFormatter::failed('gagal mengambil properti!', 404);
        }
    }

    public function createImage(Request $request){
        $image = $request->properti_image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName =  time().rand(0,2000).'.'.'png';
        File::put('properti/' . $imageName, base64_decode($image));

        return ResponseFormatter::success('berhasil mengembil mengirim gambar!', $imageName);
    }


}
