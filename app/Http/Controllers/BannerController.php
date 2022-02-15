<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;
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
            $img = Image::make($request->file('photo'));
            $filename = time().rand(1,100).'.'. $request->file('photo')->getClientOriginalExtension();
            $img_path = 'banner_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $banner->foto=$img_path;
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
            Storage::disk('public')->delete($banner->foto);
            $img = Image::make($request->file('photo'));
            $filename = time().rand(1,100).'.'. $request->file('photo')->getClientOriginalExtension();
            $img_path = 'banner_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $banner->foto=$img_path;
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
        if(is_file($image_path)){
            unlink($image_path);
        }

        $banner->delete();
        return redirect('/banner');
    }
}
