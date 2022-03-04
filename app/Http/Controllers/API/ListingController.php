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

        if($request->status){
            $diproses = rev_listing::with(
                [
                    'cluster' => function ($cluster) {
                        $cluster->select('id','name');
                    }
                ]
            )->where('status', $request->status)->orderBy('created_at', 'desc')->get(['id', 'status','image','cluster_id', 'harga', 'diskon', 'setelah_diskon', 'name']);
            if($diproses->count() == 0){
                return ResponseFormatter::failed('tidak ada listing dengan status ini!', 404);
            }

            foreach ($diproses as $q) {
                $q->image =  $q->image_url;
            }
            return ResponseFormatter::success('berhasil mengambil properti yang difilter berdasarkan input!', $diproses);
        }else if($request->name){
            $cari = rev_listing::with(
                [
                    'cluster' => function ($cluster) {
                        $cluster->select('id','name');
                    }
                ]
            )->where('name','like', "%". $request->name . "%")->get(['id', 'status','cluster_id','image', 'harga', 'diskon', 'setelah_diskon', 'name']);
            if($cari->count() == 0){
                return ResponseFormatter::failed('tidak ada listing yg dicari!', 404);
            }

            foreach ($cari as $q) {
                $q->image =  $q->image_url;
            }
            // dd($cari);
            return ResponseFormatter::success('berhasil mendapatkan yang dicari!', $cari);
        }else{
            $listing['semua'] = rev_listing::with(
                [
                    'cluster' => function ($cluster) {
                        $cluster->select('id','name');
                    }
                ]
            )->orderBy('created_at', 'desc')->get(['id', 'status','cluster_id', 'image', 'harga', 'diskon', 'setelah_diskon', 'name']);


            $listing['dengan_diskon'] = rev_listing::with(
                [
                    'cluster' => function ($cluster) {
                        $cluster->select('id','name');
                    }
                ]
            )->whereNotNull('diskon')->get(['id', 'status','cluster_id', 'image', 'harga', 'diskon', 'setelah_diskon', 'name']);

            if($listing['semua']->count() == 0){
                return ResponseFormatter::failed('tidak ada data listing !', 404);
            }

            foreach ($listing['semua'] as $q) {
                $q->image =  $q->image_url;
            }

            foreach ($listing['dengan_diskon'] as $q) {
                $q->image =  $q->image_url;
            }
            return ResponseFormatter::success('berhasil mengambil semua properti!', [$listing]);
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
