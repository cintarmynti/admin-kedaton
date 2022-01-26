<?php

namespace App\Http\Controllers;

use App\Models\Complain;
use App\Models\complain_image;
use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;


class LaporanComplainController extends Controller
{
    public function index(){
        $complain = Complain::with('user')->get();
        // dd($complain->id);
        return view('pages.laporan complain.index', ['complain' => $complain]);
    }

    public function create(){
        $user = User::all();
        return view('pages.laporan complain.create', ['user'=>$user]);
    }

    public function store(Request $request){
        $complain = new Complain();
        $complain-> user_id = $request-> user_id;
        $complain-> pesan_complain = $request-> pesan_complain;

        $complain->save();

        $files = [];
        if($request->hasfile('image'))
         {
            foreach($request->file('image') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('complain_image'), $name);
                $files[] = $name;

                $file= new complain_image();
                $file->complain_id = $complain->id;
                $file->image = $name;
                $file->save();
            }
         }

        if ($complain) {
            Alert::success('Data berhasil disimpan');
            return redirect()
                ->route('complain')
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
        $complain = Complain::findOrFail($id);
        // dd($complain->id);
        $user = User::all();
        return view('pages.laporan complain.edit', ['complain' => $complain, 'user' => $user]);

        if ($complain) {
            return redirect()
                ->route('complain')
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

    public function update(Request $request, $id){
        $complain = Complain::findOrFail($id);
        $complain-> user_id = $request-> user_id;
        $complain-> pesan_complain = $request-> pesan_complain;

        $complain->update();

        if ($complain) {

            return redirect()
                ->route('complain')
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
        $post = Complain::findOrFail($id);
        $image = complain_image::where('complain_id', $post->id)->get();

        foreach($image as $img){
            $img->delete();
            $image_path = public_path().'/complain_image/'.$img->image;
            unlink($image_path);
        }
        $post->delete();

        if ($post) {
            return redirect()
                ->route('complain')
                ->with([
                    'success' => 'Post has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('complain')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }

    public function detail($id){
        $complain = Complain::findOrFail($id);
        $image = complain_image::where('complain_id', $id)->get();
        // dd($image);
        return view('pages.laporan complain.detail', ['complain' => $complain, 'image' => $image]);
    }
}
