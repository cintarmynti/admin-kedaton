<?php

namespace App\Http\Controllers;

use App\Models\Splash;
use Illuminate\Http\Request;
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
            "desc" => "required|max:255",
        ];
        $validated = $request->validate($rule);

        if($request->hasFile('gambar'))
        {
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('splash_photo',$filename);
            $validated['gambar']=$filename;
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
            "desc" => "required|max:255",
        ];
        $validated = $request->validate($rule);

        if($request->hasFile('gambar'))
        {
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('splash_photo',$filename);
            $validated['gambar']=$filename;
        }

        Splash::where('id',$id)->update($validated);
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
        $ipkl = Splash::find($id);
        $ipkl->delete();
        return redirect('/splash-screen');
    }
}
