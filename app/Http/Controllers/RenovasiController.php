<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Renovasi;
use App\Models\renovasi_image;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\RenovasiExport;
use Maatwebsite\Excel\Facades\Excel;



class RenovasiController extends Controller
{
    public function index(){
        $renovasi = Renovasi::with('user', 'nomer')->get();

        // dd($renovasi);
        // dd($renovasi);
        return view('pages.otoritas renovasi.index', ['renovasi' => $renovasi]);
    }

    public function create(){
        $user = User::where('user_status', 'pengguna')->get();
        $nomer = Listing::all();
        return view('pages.otoritas renovasi.create', ['user' => $user, 'nomer' => $nomer]);
    }

    public function export_excel()
	{
		return Excel::download(new RenovasiExport, 'renovasi.xlsx');
	}

    public function store(Request $request){
        $renovasi = new Renovasi();
        $renovasi-> user_id = $request-> user_id;
        $renovasi-> tanggal_mulai = $request-> tanggal_mulai;
        $renovasi-> tanggal_akhir = $request-> tanggal_akhir;
        $renovasi-> catatan_renovasi = $request-> catatan_renovasi;
        $renovasi-> catatan_biasa = $request->catatan_biasa;
        $renovasi-> rumah_id = $request->rumah_id;

        $renovasi->save();

        $files = [];
        if($request->hasfile('image'))
         {
            foreach($request->file('image') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('renovasi_Image'), $name);
                $files[] = $name;

                $file= new renovasi_image();
                $file->renovasi_id = $renovasi->id;
                $file->image = $name;
                $file->save();
            }
         }

        if ($renovasi) {
            Alert::success('Data berhasil disimpan');
            return redirect()
                ->route('renovasi')
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

    public function imgdelete($id){
        $image = renovasi_image::findOrFail($id);
        // dd($image->image);

            $image_path = public_path().'/renovasi_image/'.$image->image;
            unlink($image_path);

        $image->delete();
        return redirect()->back();
    }

    public function edit($id){
        $user = User::where('user_status', 'pengguna')->get();
        $renovasi = Renovasi::with('nomer')->where('id', $id)->first();
        $rumah = Listing::all();

        // dd($renovasi);
        $image = renovasi_image::where('renovasi_id', $id)->get();

        return view('pages.otoritas renovasi.edit', ['renovasi' => $renovasi, 'user'=> $user, 'image' => $image, 'rumah' => $rumah]);
    }

    public function update(Request $request, $id){
        $renovasi = Renovasi::findOrFail($id);
        $renovasi-> user_id = $request-> user_id;
        $renovasi-> tanggal_mulai = $request-> tanggal_mulai;
        $renovasi-> tanggal_akhir = $request-> tanggal_akhir;
        $renovasi-> catatan_renovasi = $request-> catatan_renovasi;
        $renovasi-> catatan_biasa = $request->catatan_biasa;
        $renovasi-> rumah_id = $request->rumah_id;


        $renovasi->update();

        if ($renovasi) {
            Alert::success('Data berhasil diupdate');
            return redirect()
                ->route('renovasi')
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
        $post = Renovasi::findOrFail($id);
        $image = renovasi_image::where('renovasi_id', $post->id)->get();

        foreach($image as $img){
            $img->delete();
            $image_path = public_path().'/renovasi_image/'.$img->image;
            unlink($image_path);
        }
        $post->delete();

        if ($post) {
            return redirect()
                ->route('renovasi')
                ->with([
                    'success' => 'Post has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('renovasi')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }

    public function detail($id){
        $renovasi = Renovasi::findOrFail($id);
        $image = renovasi_image::where('renovasi_id', $id)->get();
        // dd($image);
        return view('pages.otoritas renovasi.detail', ['renovasi' => $renovasi, 'image' => $image]);
    }
}
