<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function getBanner()
    {
        $banner = Banner::all();
        if($banner){
            return ResponseFormatter::success('berhasil mengembil banner!', $banner);
        }else{
            return ResponseFormatter::failed('gagal mengambil banner!', 404);
        }
    }
}
