<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(){
        $promo = Promo::all();
        return view('pages.promo.index', ['promo' => $promo]);
    }

    public function create(){
        return view('pages.promo.create');
    }

    public function store(Request $request){
        $promo = new Promo();
        $promo-> judul = $request->judul;
        $promo->link = $request->link;
        if($request->hasFile('photo'))
        {
            $file = $request->file('photo');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('promo_photo',$filename);
            $promo->foto=$filename;
        }
        $promo->save();

        if ($promo) {
            return redirect()
                ->route('promo')
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

    public function edit($id){
        $promo = Promo::findOrFail($id);
        return view('pages.promo.edit', ['promo' => $promo]);
    }

    public function update(Request $request,$id){
        $promo = Promo::findOrFail($id);
        $promo-> judul = $request->judul;
        $promo->link = $request->link;
        if($request->hasFile('photo'))
        {
            $destination = public_path().'/promo_photo/'.$promo->foto;
            // dd($destination);
            if(File::exists($destination))
            {
                unlink($destination);
            }
            $file = $request->file('photo');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('promo_photo',$filename);
            $promo->foto=$filename;
        }
        $promo->update();

        if ($promo) {
            return redirect()
                ->route('promo')
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
        $promo = Promo::find($id);
        $image_path = public_path().'/promo_photo/'.$promo->foto;
        unlink($image_path);
        $promo->delete();
        return redirect('/promo');
    }
}
