<?php

namespace App\Http\Controllers;

use App\Models\Splash;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SplashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.splash_screen.index',[
            "splash" => Splash::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.splash_screen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            "judul" => "required|max:120",
            "gambar" => "required|image|file",
            "desc" => "required"
        ];
        $validated = $request->validate($rule);

        if($request->hasFile('gambar'))
        {
            // $filename = time().'.'.$request->file('gambar')->getClientOriginalExtension();
            // $img_path = 'splash_photo/'.$filename;
            // Storage::put($img_path, $$filename->encode());
            // $validated['gambar']=$img_path;
            $img = Image::make($request->file('gambar'));
            $filename = time().rand(1,100).'.'. $request->file('gambar')->getClientOriginalExtension();
            $img_path = 'splash_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $validated['gambar']=$img_path;
        }

        Splash::create($validated);
        Alert::success('Data berhasil disimpan');
        return redirect('/splash-screen');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plash = Splash::findOrFail($id);
        return view('pages.splash_screen.edit',[
            "sp" => $plash
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rule = [
            "judul" => "required|max:120",
            "gambar" => "image|file",
            "desc" => "required"
        
        ];
        $validated = $request->validate($rule);
        $splash = Splash::findOrFail($id);
        if($request->hasFile('gambar'))
        {
            Storage::disk('public')->delete($splash->gambar);
            $img = Image::make($request->file('gambar'));
            $filename = time().'.'. $request->file('gambar')->getClientOriginalExtension();
            $img_path = 'splash_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $validated['gambar'] = $img_path;
        }

        $splash->update($validated);
        Alert::success('Data berhasil diupdate');
        return redirect('/splash-screen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $splash = Splash::find($id);
        Storage::disk('public')->delete($splash->gambar);
        $splash->delete();
        return redirect('/splash-screen');
    }
}
