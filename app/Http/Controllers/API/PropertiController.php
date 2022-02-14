<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use Illuminate\Http\Request;
use App\Models\Properti;
use App\Models\Properti_image;
use App\Models\tarif_ipkl;
use Illuminate\Support\Facades\File;


class PropertiController extends Controller
{
   public function store(Request $request)
   {
    $properti = new Properti();
    $properti->alamat = $request-> alamat;
    $properti->no_rumah = $request-> no;
    $properti->no_listrik = $request->listrik;
    $properti->no_pam_bsd = $request->pam;
    $properti->RT = $request-> RT;
    $properti->RW = $request-> RW;
    $properti->lantai = $request->lantai;
    $properti->jumlah_kamar = $request->jumlah_kamar;
    $properti->luas_tanah = $request->luas_tanah; //ini luas kavling
    $properti->luas_bangunan = $request->luas_bangunan;
    $properti->penghuni_id = $request->penghuni;
    $properti->pemilik_id = $request->pemilik;
    $properti->status = $request->status;
    $properti->harga = $request->harga;
    $properti->cluster_id = $request->cluster_id;

    $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', $request-> luas_tanah)->where('luas_kavling_akhir', '>=', $request-> luas_tanah)->first();

    $terkecil = tarif_ipkl::orderBy('luas_kavling_awal', 'asc')->first();
    $terbesar = tarif_ipkl::orderBy('luas_kavling_akhir', 'desc')->first();

    if($ipkl == null){
        if($request->luas_tanah <= $terbesar && $request->luas_tanah <= $terkecil){
            $properti-> tarif_ipkl = $terkecil->tarif * $request->luas_tanah;
        }else if($request->luas_tanah >= $terbesar && $request->luas_tanah >= $terkecil){
            $properti-> tarif_ipkl = $terbesar->tarif * $request->luas_tanah;
        }
    }else if($ipkl != null){
        $properti->tarif_ipkl = $ipkl->tarif * $request-> luas_tanah;
    }

    $cluster = Cluster::where('id', $request->cluster_id)->first();
    // dd($cluster);
    if ($cluster === null) {
        // User does not exist
        $clus = new Cluster();
        $clus->name = $request->cluster_id;
        $clus->save();

        $properti->cluster_id = $clus->id;

    } else {
        $properti->cluster_id = $request->cluster_id;
    }


    if($request->hasfile('image'))
     {
        foreach($request->file('image') as $file)
        {
            $image = $request->photo_identitas;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName =  time().rand(0,2000).'.'.'png';
            File::put('properti_photo/' . $imageName, base64_decode($image));

            $file= new Properti_image();
            $file->properti_id = $properti->id;
            $file->image = '/properti_photo/'.$imageName;
            $file->save();
        }
     }

     $properti->save();

     if($properti){
         
     }

   }
}
