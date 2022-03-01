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
        // $banner = Banner::all();
        // $banner->image_url->get();
        $banner = Banner::all();

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
        // $detail_image = blog_image::where('blog_id')

        foreach($articel as $q){
            $q->gambar = $q->image_url;
        };

        if($articel){
            return ResponseFormatter::success('berhasil mengembil banner!', $articel);
        }else{
            return ResponseFormatter::failed('gagal mengambil banner!', 404);
        }
    }

    public function getArtikelDetail($id)
    {
        $article = Blog::with('blog_image')->where('id', $id)->first();
        $article->image_url;
        // dd($article);
        $article_rekomendation = Blog::inRandomOrder(3)->get();
        if($article){
            return ResponseFormatter::success('berhasil mengambil banner!', [$article, $article_rekomendation]);
        }else{
            return ResponseFormatter::failed('gagal mengambil banner!', 404);
        }
    }


}
