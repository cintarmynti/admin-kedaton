<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(){
        $users = User::where('user_status', 'pengguna')->get();
        return view('pages.user.index', ['users' => $users]);
    }

    public function export_excel(){
        return Excel::download(new UserExport, 'user.xlsx');
    }

    public function create(){
        return view('pages.user.create');

    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'password' => 'required|min:8',
            'nik' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'phone' => 'required',

        ]);


        $user = new User();
        $user-> name = $request->name;
        $user->nik = $request->nik;
        $user->alamat= $request->alamat;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user-> password = bcrypt($request->password);

        $user->user_status = 'pengguna';
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
            Alert::success('Data berhasil disimpan');
            return redirect()
                ->route('user');
        } else {
            return redirect()
                ->back()
                ->withInput();
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
        $user->alamat= $request->alamat;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user-> password = bcrypt($request->password);
        $user->user_status = 'pengguna';
        if($request->hasFile('photo_identitas'))
        {

            $destination = public_path().'/user_photo/'.$user->photo_identitas;
            $identitas = $user->photo_identitas;

            if($identitas == null){
                $file = $request->file('photo_identitas');
                $extention = $file->getClientOriginalExtension();
                $filename=time().'.'.$extention;
                $file->move('user_photo',$filename);
                $user->photo_identitas=$filename;
            }
            else if(File::exists($destination))
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
            Alert::success('Data berhasil diupdate');
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
        $image_path = public_path().'/user_photo/'.$user->photo_identitas;
        unlink($image_path);
        $user->delete();
        return redirect('/user');
    }
}
