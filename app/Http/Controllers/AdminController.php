<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $user = User::where('user_status', 'admin')->get();
        return view('pages.admin.index', ['users' => $user]);
    }

    public function create()
    {
        return view('pages.admin.create');
    }

    public function store(Request $request)
    {
        $user= new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_status = 'admin';
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/admin');
    }

    public function edit($id)
    {
        // dd($id);
        $user = User::find($id);
        // dd($user);
        return view('pages.admin.edit', ['user' => $user]);

    }

    public function update(Request $request)
    {
        $user= User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_status = 'admin';
        if($request->password != null){
            $user->password = Hash::make($request->password);
        }
        $user->update();

        return redirect('/admin');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/admin');
    }
}
