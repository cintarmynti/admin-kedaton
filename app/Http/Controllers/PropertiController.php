<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Cluster;
use App\Models\Listing;
use App\Models\Properti;
use App\Models\tarif_ipkl;
use Illuminate\Http\Request;
use App\Models\listing_image;
use App\Models\Properti_image;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Console\Input\Input;


class PropertiController extends Controller
{
    public function index(){
        $properti = Properti::all();
        return view('pages.properti.index', ['properti' => $properti]);
    }

    public function create(){
        $cluster = Cluster::all();
        $user = User::where('user_status', 'pengguna')->get();
        return view('pages.properti.create', ['user' => $user, 'cluster' => $cluster ]);
    }

    public function store(Request $request){
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

        $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', $request-> luas_tanah)->where('luas_kavling_akhir', '>=', $request-> luas_tanah)->first();
        // dd($ipkl);

        // $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', 12)->where('luas_kavling_akhir', '>=', 12)->first();


        $terkecil = tarif_ipkl::orderBy('luas_kavling_awal', 'asc')->first();
        $terbesar = tarif_ipkl::orderBy('luas_kavling_akhir', 'desc')->first();

        // dd($terbesar);

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


        $properti->save();
        // $properti->update(); belum bisa


        // $files = [];
        if($request->hasfile('image'))
         {
            foreach($request->file('image') as $file)
            {
                // $name = time().rand(1,100).'.'.$file->extension();
                // $file->move(public_path('files'), $name);
                // $files[] = $name;
                $img = Image::make($file);
                $img->resize(521, null,  function ($constraint)
                {
                    $constraint->aspectRatio();
                });

                $filename = time().rand(1,100).'.'.$file->getClientOriginalExtension();
                $img_path = 'properti_photo/'.$filename;
                Storage::put($img_path, $img->encode());

                $file= new Properti_image();
                $file->properti_id = $properti->id;
                $file->image = $img_path;
                $file->save();
            }
         }


        if ($properti) {
            Alert::success('Data berhasil disimpan');

            return redirect()
                ->route('properti')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function detail($id){
        $properti = Properti::with('penghuni', 'pemilik')->where('id', $id)->first();
        $image = Properti_image::where('properti_id', $id)->get();
        // $listing = Listing::findOrFail($id);
        // dd($listing);
        return view('pages.properti.detail',['properti' => $properti, 'image' =>$image]);
    }

    public function edit($id){
        $properti = Properti::findOrFail($id);
        $user = User::where('user_status', 'pengguna')->get();
        $cluster = Cluster::all();
        $image = properti_image::where('properti_id', $id)->get();
        return view('pages.properti.edit', ['properti' => $properti, 'user'=> $user, 'cluster' => $cluster, 'image' => $image]);
    }

    public function imgdelete($id){
        $image = Properti_image::findOrFail($id);
        Storage::delete($image->image);
        $image->delete();
        return redirect()->back();
    }

    public function update(Request $request, $id){
        $properti = properti::findOrFail($id);
        $properti-> alamat = $request-> alamat;
        $properti-> no_rumah = $request-> no;
        $properti->no_listrik = $request->listrik;
        $properti->no_pam_bsd = $request->pam;
        $properti-> RT = $request-> RT;
        $properti-> RW = $request-> RW;
        $properti-> lantai = $request->lantai;
        $properti->jumlah_kamar = $request->jumlah_kamar;
        $properti-> luas_tanah = $request->luas_tanah;
        $properti->luas_bangunan = $request->luas_bangunan;
        $properti->penghuni_id = $request->penghuni;
        $properti->pemilik_id = $request->pemilik;
        $properti-> status = $request->status;
        $properti->harga = $request->harga;

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

        $properti->update();

        if($request->hasfile('image'))
         {
            foreach($request->file('image') as $file)
            {
                // $name = time().rand(1,100).'.'.$file->extension();
                // $file->move(public_path('files'), $name);
                // $files[] = $name;
                $img = Image::make($file);
                $img->resize(521, null,  function ($constraint)
                {
                    $constraint->aspectRatio();
                });

                $filename = time().rand(1,100).'.'.$file->getClientOriginalExtension();
                $img_path = 'properti_photo/'.$filename;
                Storage::put($img_path, $img->encode());

                $file= new Properti_image();
                $file->properti_id = $properti->id;
                $file->image = $img_path;
                $file->save();
            }
         }

        if ($properti) {
            Alert::success('Data berhasil diupdate');
            return redirect()
                ->route('properti')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function delete($id){
        $properti = Properti::findOrFail($id);
        $image = Properti_image::where('properti_id', $properti->id)->get();

        foreach($image as $img){
            $img->delete();
            Storage::delete($img->image);
        }
        $properti->delete();

        if ($properti) {
            return redirect()
                ->route('properti')
                ->with([
                    'success' => 'Properti has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('properti')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
