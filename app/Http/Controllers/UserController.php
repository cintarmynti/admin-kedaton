<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('pages.user.index', ['users' => $users]);
    }

    public function create(){
        return view('pages.user.create');

    }

    public function store(Request $request){


        $user = new User();
        $user-> name = $request->name;
        $user->nik = $request->nik;
        $user->alamat=$request->alamat;
        $user->phone = $request->phone;
        if($request->hasFile('photo_identitas'))
        {
            $file = $request->file('photo_identitas');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('user_photo',$filename);
            $user->photo_identitas=$filename;
        }
        $user->save();

        if ($user) {
            return redirect()
                ->route('user')
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
        $user = User::findOrFail($id);
        return view('pages.user.edit', ['user' => $user]);

    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $user-> name = $request->name;
        $user->nik = $request->nik;
        $user->alamat=$request->alamat;
        $user->phone = $request->phone;
        $destination = $user->photo_identitas;
        if($request->hasFile('photo_identitas'))
        {
            // dd($destination);
            if(File::exists($destination))
            {
                unlink($destination);
            }
            $file = $request->file('photo_identitas');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('user_photo',$filename);
            $user->photo_identitas=$filename;
        }
        $user->update();

        if ($user) {
            return redirect()
                ->route('user')
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
        $user = User::find($id);
        // dd($user);
        // dd($paymentkata);
        $image_path = public_path().'/user_photo/'.$user->photo_identitas;
        // dd($image_path);
        unlink($image_path);
        $user->delete();
        return redirect('/user');
    }
}
