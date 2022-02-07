<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Listing;
use App\Models\listing_image;
use App\Models\Properti;
use App\Models\tarif_ipkl;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\Console\Input\Input;
use RealRashid\SweetAlert\Facades\Alert;


class ListingController extends Controller
{
    public function index(){
        $listing = Listing::all();
        return view('pages.listing.index', ['listing' => $listing]);
    }

    public function create(){
        $cluster = Cluster::all();
        $user = User::where('user_status', 'pengguna')->get();
        return view('pages.listing.create', ['user' => $user, 'cluster' => $cluster ]);
    }

    public function store(Request $request){
        $listing = new Listing();
        $listing-> alamat = $request-> alamat;
        $listing-> no_rumah = $request-> no;
        $listing-> RT = $request-> RT;
        $listing-> RW = $request-> RW;
        $listing-> lantai = $request->lantai;
        $listing->jumlah_kamar = $request->jumlah_kamar;
        $listing-> luas_tanah = $request->luas_tanah; //ini luas kavling
        $listing->luas_bangunan = $request->luas_bangunan;
        $listing-> user_id_penghuni = $request->penghuni;
        $listing->user_id_pemilik = $request->pemilik;
        $listing-> status = $request->status;
        $listing->harga = $request->harga;
        $properti = new Properti();
        $properti-> alamat = $request-> alamat;
        $properti-> no_rumah = $request-> no;
        $properti-> RT = $request-> RT;
        $properti-> RW = $request-> RW;
        $properti-> lantai = $request->lantai;
        $properti->jumlah_kamar = $request->jumlah_kamar;
        $properti-> luas_tanah = $request->luas_tanah; //ini luas kavling
        $properti->luas_bangunan = $request->luas_bangunan;
        $properti-> penghuni_id = $request->user_id_penghuni;
        $properti->pemilik_id = $request->user_id_pemilik;
        $properti-> status = $request->status;
        $properti->harga = $request->harga;

        $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', $request-> luas_tanah)->where('luas_kavling_akhir', '>=', $request-> luas_tanah)->first();
        // dd($ipkl);

        // $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', 12)->where('luas_kavling_akhir', '>=', 12)->first();


        $terkecil = tarif_ipkl::orderBy('luas_kavling_awal', 'asc')->first();
        $terbesar = tarif_ipkl::orderBy('luas_kavling_akhir', 'desc')->first();

        // dd($terbesar);

        if($ipkl == null){
            if($request->luas_tanah <= $terbesar && $request->luas_tanah <= $terkecil){
                $listing-> tarif_ipkl = $terkecil->tarif * $request->luas_tanah;
                $properti-> tarif_ipkl = $terkecil->tarif * $request->luas_tanah;
            }else if($request->luas_tanah >= $terbesar && $request->luas_tanah >= $terkecil){
                $listing-> tarif_ipkl = $terbesar->tarif * $request->luas_tanah;
                $properti-> tarif_ipkl = $terbesar->tarif * $request->luas_tanah;
            }
        }else if($ipkl != null){
            $listing->tarif_ipkl = $ipkl->tarif * $request-> luas_tanah;
            $properti->tarif_ipkl = $ipkl->tarif * $request-> luas_tanah;
        }



        $cluster = Cluster::where('name', '=', $request->cluster_id)->first();
        // dd($cluster);
        if ($cluster === null) {
            // User does not exist
            $clus = new Cluster();
            $clus->name = $request->cluster_id;
            $clus->save();

            $listing->cluster_id = $clus->id;
            $properti->cluster_id = $clus->id;

          } else {
            $cls = Cluster::where('name', '=', $request->cluster_id)->first();
            // dd($cls->id);
            $listing->cluster_id = $cls->id;
            $properti->cluster_id = $cls->id;
          }


        $listing->save();
        // $properti->update(); belum bisa
        

        $files = [];
        if($request->hasfile('image'))
         {
            foreach($request->file('image') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('files'), $name);
                $files[] = $name;

                $file= new listing_image();
                $file->listing_id = $listing->id;
                $file->image = $name;
                $file->save();
            }
         }


        if ($listing) {
            Alert::success('Data berhasil disimpan');

            return redirect()
                ->route('listing')
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
        $listing = Listing::with('user_penghuni', 'user_pemilik')->where('id', $id)->first();
        $image = listing_image::where('listing_id', $id)->get();
        // $listing = Listing::findOrFail($id);
        // dd($listing);
        return view('pages.listing.detail',['listing' => $listing, 'image' =>$image]);
    }

    public function edit($id){
        $listing = Listing::findOrFail($id);
        $user = User::where('user_status', 'pengguna')->get();
        $cluster = Cluster::all();
        $image = listing_image::where('listing_id', $id)->get();
        return view('pages.listing.edit', ['listing' => $listing, 'user'=> $user, 'cluster' => $cluster, 'image' => $image]);
    }

    public function imgdelete($id){
        $image = Listing_image::findOrFail($id);
        // dd($image->image);
        // if(file_exists($image->image)){
            $image_path = public_path().'/files/'.$image->image;
            unlink($image_path);
        // }
        $image->delete();
        return redirect()->back();
    }

    public function update(Request $request, $id){
        $listing = Listing::findOrFail($id);
        $listing-> alamat = $request-> alamat;
        $listing-> no_rumah = $request-> no;
        $listing-> RT = $request-> RT;
        $listing-> RW = $request-> RW;
        $listing-> lantai = $request->lantai;
        $listing->jumlah_kamar = $request->jumlah_kamar;
        $listing-> luas_tanah = $request->luas_tanah;
        $listing->luas_bangunan = $request->luas_bangunan;
        $listing-> user_id_penghuni = $request->penghuni;
        $listing->user_id_pemilik = $request->pemilik;
        $listing-> status = $request->status;
        $listing->harga = $request->harga;
        $listing->cluster_id = $request->cluster_id;

        $listing->update();

        if ($listing) {
            Alert::success('Data berhasil diupdate');
            return redirect()
                ->route('listing')
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
        $post = Listing::findOrFail($id);
        $image = listing_image::where('listing_id', $post->id)->get();

        foreach($image as $img){
            $img->delete();
            $image_path = public_path().'/files/'.$img->image;
            unlink($image_path);
        }
        $post->delete();

        if ($post) {
            return redirect()
                ->route('listing')
                ->with([
                    'success' => 'Post has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('listing')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
