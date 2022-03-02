<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Banner;
use App\Models\blog_image;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    public function getBanner()
    {

        $banner = Banner::all();
        $banyak_banner = Banner::all()->count();
        // dd($banyak_banner);
        if($banyak_banner == 0){
            return ResponseFormatter::failed('tidak ada banner!', 404);
        }

        foreach($banner as $q){
            $q->foto = $q->image_url;
        };

        if($banner){
            return ResponseFormatter::success('berhasil mengembil banner!', $banner);
        }else{
            return ResponseFormatter::failed('gagal mengambil banner!', 404);
        }
    }

    public function getArtikel()
    {
        $articel = Blog::orderBy('created_at', 'desc')->get();
        $banyak_articel = Blog::all()->count();
        // $detail_image = blog_image::where('blog_id')

        if($banyak_articel == 0){
            return ResponseFormatter::failed('tidak ada articel!', 404);
        }

        foreach($articel as $q){
            $q->gambar = $q->image_url;
        };

        if($articel){
            return ResponseFormatter::success('berhasil mengembil banner!', $articel);
        }else{
            return ResponseFormatter::failed('gagal mengambil banner!', 404);
        }
    }

    public function getArtikelDetail(Request $request)
    {
        if(!$request->artikel_id){
            return ResponseFormatter::failed('masukkan id terlebih dahulu!', 404);
        }

        $article['blog'] = Blog::where('id', $request->artikel_id)->first();

        if($article['blog'] == null){
            return ResponseFormatter::failed('tidak ada id dengan artikel tersebut!', 404);
        }

        if($article ==  null){
            return ResponseFormatter::failed('tidak ada article dengan id ini!', 404);
        }
        $article['blog']->gambar = $article['blog']->image_url;

        $article['rekomendasi'] = Blog::inRandomOrder(3)->get();
        foreach($article['rekomendasi'] as $q){
            $q->gambar = $q->image_url;
        };
        // dd($article);
        if($article){
            return ResponseFormatter::success('berhasil mengambil banner!', [$article]);
        }else{
            return ResponseFormatter::failed('gagal mengambil banner!', 404);
        }
    }


}
