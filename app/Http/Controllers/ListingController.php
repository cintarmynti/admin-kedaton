<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Listing;
use App\Models\listing_image;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class ListingController extends Controller
{
    public function index(){
        $listing = Listing::all();
        return view('pages.listing.index', ['listing' => $listing]);
    }

    public function create(){
        $cluster = Cluster::all();
        $user = User::all();
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
        $listing-> luas_tanah = $request->luas_tanah;
        $listing->luas_bangunan = $request->luas_bangunan;
        $listing-> user_id_penghuni = $request->penghuni;
        $listing->user_id_pemilik = $request->pemilik;
        $listing-> status = $request->status;
        $listing->harga = $request->harga;

        $cluster = Cluster::where('name', '=', $request->cluster_id)->first();
        // dd($cluster);
        if ($cluster === null) {
            // User does not exist
            $clus = new Cluster();
            $clus->name = $request->cluster_id;
            $clus->save();

            $listing->cluster_id = $clus->id;

          } else {
            $cls = Cluster::where('name', '=', $request->cluster_id)->first();
            // dd($cls->id);
            $listing->cluster_id = $cls->id;
          }


        $listing->save();


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
        // $listing = Listing::findOrFail($id);
        // dd($listing);
        return view('pages.listing.detail',['listing' => $listing]);
    }

    public function edit($id){
        $listing = Listing::findOrFail($id);
        $user = User::all();
        return view('pages.listing.edit', ['listing' => $listing, 'user'=> $user]);
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

        $listing->update();

        if ($listing) {
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
