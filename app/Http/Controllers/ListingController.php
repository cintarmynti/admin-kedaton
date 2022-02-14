<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Cluster;
use App\Models\Properti;
use App\Models\tarif_ipkl;
use App\Models\rev_listing;
use Illuminate\Http\Request;
use App\Models\listing_image;
use App\Models\Properti_image;
use App\Exports\PropertiExport;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Console\Input\Input;


class ListingController extends Controller
{
    public function index(){
        $listing = rev_listing::all();
        return view('pages.listing.index', ['listing' => $listing]);
    }

    public function create(){
        return view('pages.listing.create', ['properti' => Properti::all() ]);
    }

    public function export_excel()
	{
		return Excel::download(new PropertiExport, 'properti.xlsx');
	}

    public function store(Request $request){
        $listing = new rev_listing();
        $listing->harga = $request->harga;
        $listing->name = $request->name;
        $listing->diskon = $request->diskon;
        $listing->status = $request->status;
        $listing->properti_id = $request->properti_id;
        // dd($request->harga);
        if ($request->diskon != null) {
            $harga = str_replace( ',', '', $request->harga);
            $setelah_diskon = intval($harga) * intval($request->diskon) / 100;
            $listing->setelah_diskon = $setelah_diskon;
        }

        if ($request->hasFile('image')) {
            $img = Image::make($request->file('image'));
            $img->resize(521, null,  function ($constraint)
            {
                $constraint->aspectRatio();
            });
            $filename = time().'.'.$request->file('image')->getClientOriginalExtension();
            $img_path = 'rev_listing_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $listing->image = $img_path;
        }


        $listing->save();



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
        $properti = Properti::with('penghuni', 'pemilik', 'cluster')->where('id', $id)->first();
        // dd($properti);
        $image = Properti_image::where('properti_id', $id)->get();
        // $listing = Listing::findOrFail($id);
        // dd($listing);
        return view('pages.listing.detail',['properti' => $properti, 'image' =>$image]);
    }

    public function edit($id){
        $properti = Properti::findOrFail($id);
        $user = User::where('user_status', 'pengguna')->get();
        $cluster = Cluster::all();
        $image = properti_image::where('properti_id', $id)->get();
        return view('pages.listing.edit', ['properti' => $properti, 'user'=> $user, 'cluster' => $cluster, 'image' => $image]);
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
