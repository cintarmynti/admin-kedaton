<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class BannerController extends Controller
{
    public function index(){
        $banner = Banner::all();
        return view('pages.banner.index', ['banner' => $banner]);
    }

    public function create(){
        return view('pages.banner.create');
    }

    public function store(Request $request){
        $banner = new Banner();
        $banner-> judul = $request->judul;
        $banner->link = $request->link;
        if($request->hasFile('photo'))
        {
<<<<<<< HEAD
            $img = Image::make($request->file('photo'));
            $filename = time().rand(1,100).'.'. $request->file('photo')->getClientOriginalExtension();
            $img_path = 'banner_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $banner->foto=$img_path;
=======
            $file = $request->file('photo');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('banner_photo',$filename);
            $banner->foto='/banner_photo/'.$filename;
>>>>>>> 77037f2bdd383315449a0e5ab7ed07e4f2c85de3
        }
        $banner->save();

        if ($banner) {
            Alert::success('Data berhasil disimpan');
            return redirect()
                ->route('banner')
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
        $banner = Banner::findOrFail($id);
        return view('pages.banner.edit', ['banner' => $banner]);
    }

    public function update(Request $request, $id){
        $banner = Banner::findOrFail($id);
        $banner-> judul = $request->judul;
        $banner->link = $request->link;
        if($request->hasFile('photo'))
        {
<<<<<<< HEAD
            Storage::disk('public')->delete($banner->foto);
            $img = Image::make($request->file('photo'));
            $filename = time().rand(1,100).'.'. $request->file('photo')->getClientOriginalExtension();
            $img_path = 'banner_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $banner->foto=$img_path;
=======
            $destination = public_path().$banner->foto;
            // dd($destination);
            if(File::exists($destination))
            {
                unlink($destination);
            }
            $file = $request->file('photo');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('banner_photo',$filename);
            $banner->foto='/banner_photo/'.$filename;
>>>>>>> 77037f2bdd383315449a0e5ab7ed07e4f2c85de3
        }
        $banner->update();

        if ($banner) {
            Alert::success('Data berhasil diupdate');
            return redirect()
                ->route('banner')
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
        $banner = Banner::find($id);
        $image_path = public_path().'/'.$banner->foto;
        unlink($image_path);
        $banner->delete();
        return redirect('/banner');
    }
}
