<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Cluster;
use App\Models\Riwayat;
use App\Models\Properti;
use App\Models\Pembayaran;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Models\Properti_image;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(){
        $users = User::where('user_status', 'pengguna')->get();
        return view('pages.user.index', ['users' => $users]);
    }

    public function export_excel(){
        return Excel::download(new UserExport, 'pengguna.xlsx');
    }

    public function create(){
        return view('pages.user.create', ['cluster' => $cluster = Cluster::all()]);

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
            dd($identitas);
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
        // dd($user->photo_identitas);
        if($user->photo_identitas != null){
            $image_path = public_path().'/user_photo/'.$user->photo_identitas;
            unlink($image_path);
            $user->delete();
        }

        $user->delete();
        return redirect('/user');
    }

    public function show($id)
    {
        if (Properti::where('pemilik_id',$id) == null) {
            $properti = Properti::where('penghuni_id',$id)->get();
         } else {
            $properti = Properti::where('pemilik_id',$id)->get();
         }
        return view('pages.user.detail',[
           "properti" => $properti,
           "user" => User::find($id)
       ]);
    }

    public function detail_rumah($id)
    {
        $properti = Properti::with('penghuni', 'pemilik')->where('id', $id)->first();
        $image = Properti_image::where('properti_id', $id)->get();
        // $listing = Listing::findOrFail($id);
        // dd($listing);
        return view('pages.properti.detail',['properti' => $properti, 'image' =>$image]);
    }
}
