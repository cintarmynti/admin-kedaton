<?php

namespace App\Http\Controllers;

use App\Exports\ListingExport;
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
        $listing = rev_listing::orderby('created_at', 'desc')->get();
        return view('pages.listing.index', ['listing' => $listing]);
    }

    public function create(){
        $nomer = Properti::all();
        $cluster = Cluster::all();
        return view('pages.listing.create', ['properti' => Properti::all(), 'cluster' => $cluster ]);
    }

    public function getProperti($id){
        $listing = Properti::find($id);
        // dd($listing);
        return response()->json($listing);
        // $html   = '';
        // $html .= $listing['tarif_ipkl'];
        // echo $html;
    }

    // public function export_excel()
	// {
	// 	return Excel::download(new PropertiExport, 'properti.xlsx');
	// }

    public function store(Request $request){
        // dd($request->all());
        $listing = new rev_listing();
        $listing->harga = $request->harga;
        $listing->name = $request->name;
        $listing->diskon = $request->diskon;
        $listing->status = $request->status;
        $listing->properti_id = $request->properti_id;
        $listing->cluster_id = $request->cluster_id;
        $listing->setelah_diskon = $request->setelah_diskon;


        // dd($request->harga);
        // if ($request->diskon != null) {
        //     $harga = str_replace( ',', '', $request->harga);
        //     $setelah_diskon = intval($harga) * intval($request->diskon) / 100;
        //     $setelah_diskon = $harga - $setelah_diskon;
        //     $listing->setelah_diskon = $setelah_diskon;
        // }

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
        $cluster = Cluster::all();
        $properti = Properti::all();
        $listing = rev_listing::with('properti')->find($id);
        return view('pages.listing.edit', ['properti' => $properti, 'listing'=> $listing, 'cluster' => $cluster]);
    }

    public function update(Request $request, $id){
        $listing = rev_listing::findOrFail($id);
        $listing->harga = $request->harga;
        $listing->name = $request->name;
        $listing->diskon = $request->diskon;
        $listing->status = $request->status;
        $listing->properti_id = $request->properti_id;
        $listing->cluster_id = $request->cluster_id;
        $listing->setelah_diskon = $request->setelah_diskon;


        // dd($request->harga);
        // if ($request->diskon != null) {
        //     $harga = str_replace( ',', '', $request->harga);
        //     $setelah_diskon = intval($harga) * intval($request->diskon) / 100;
        //     $setelah_diskon = $harga - $setelah_diskon;
        //     $listing->setelah_diskon = $setelah_diskon;
        // }

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
        $listing = rev_listing::findOrFail($id);
        $listing->delete();

        if ($listing) {
            return redirect()
                ->route('listing')
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

    public function export_excel()
	{
		return Excel::download(new ListingExport, 'Listing.xlsx');
	}
}
