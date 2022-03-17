<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\rev_listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\API\ResponseFormatter;
use App\Models\Properti_image;
use App\Models\User;
use App\Models\Cluster;

class ListingController extends Controller
{
    // ini yang udah di revisi
    public function getProperti(Request $request){

        if($request->status){
            $diproses = rev_listing::with(
                [
                    'cluster' => function ($cluster) {
                        $cluster->select('id','name');
                    },
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

    public function detail_listing(Request $request){

        if(!$request->listing_id){
            return ResponseFormatter::failed('tidak boleh ada field kosong!', 404);
        }
        if(rev_listing::where('id', $request->listing_id)->first() == null){
            return ResponseFormatter::failed('tidak ada listing dengan id ini!', 404);
        }
        $listing['data'] = rev_listing::with(
            [
                'properti' => function($properti){
                    $properti->select('id','luas_bangunan', 'pemilik_id', 'luas_tanah', 'jumlah_kamar', 'kamar_mandi', 'carport');
                },
                'cluster' => function ($cluster) {
                    $cluster->select('id','name');
                },
                'properti.penghuni' => function($pemilik){
                    $pemilik->select('id', 'name', 'photo_identitas', 'phone');
                },
                'properti.pemilik' => function($pemilik){
                    $pemilik->select('id', 'name', 'photo_identitas', 'phone');
                }
            ]
        )->where('id', $request->listing_id)->first(['id', 'status','cluster_id', 'properti_id', 'image', 'harga', 'diskon', 'setelah_diskon', 'name', 'desc']);
        $listing['data']->image = $listing['data']->image_url;
        // $listing['data']->phone =  $listing['data']->telp;

        $listing['image_detail'] = Properti_image::where('properti_id', $listing['data']->properti_id)->get(['id', 'image']);
        foreach($listing['image_detail'] as $q){
            $q->image =  $q->image_url;

        }

        // $listing['pemilik'] = User::where('id', $listing['data']->properti)->first();

        return ResponseFormatter::success('berhasil mengambil semua properti!', $listing);

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
