<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Cluster;
use App\Models\Riwayat;
use App\Models\Properti;
use App\Models\Pembayaran;
use App\Exports\UserExport;
use App\Models\PenghuniDetail;
use Illuminate\Http\Request;
use App\Models\Properti_image;
use App\Models\tarif_ipkl;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(){
        $users = User::where('user_status', 'pengguna')->get();
        // $properti = Properti::where()
        return view('pages.user.index', ['users' => $users]);
    }

    public function export_excel(){
        return Excel::download(new UserExport, 'pengguna.xlsx');
    }

    public function create(){
        $cluster = Cluster::all();
        $user = User::where('user_status', 'pengguna')->get();
        return view('pages.user.create', ['cluster' => $cluster, 'user' => $user]);

    }

    public function storePenghuni(Request $request){
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
        $user->status_penghuni = $request->status_penghuni;
        $user->user_status = 'pengguna';
        $user->status_penghuni = 'penghuni';
        if($request->hasFile('photo_identitas'))
        {
            // $file = $request->file('photo_identitas');
            // $extention = $file->getClientOriginalExtension();
            // $filename=time().'.'.$extention;
            // $file->move('user_photo',$filename);
            // $user->photo_identitas=$filename;
            $img = Image::make($request->file('photo_identitas'));
            $img->resize(521, null,  function ($constraint)
            {
                $constraint->aspectRatio();
            });
            $filename = time().'.'.$request->file('photo_identitas')->getClientOriginalExtension();
            $img_path = 'user_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $user->photo_identitas = $img_path;
        }

        if($request->hasFile('photo_ktp'))
        {
            // $file = $request->file('photo_identitas');
            // $extention = $file->getClientOriginalExtension();
            // $filename=time().'.'.$extention;
            // $file->move('user_photo',$filename);
            // $user->photo_identitas=$filename;
            $img = Image::make($request->file('photo_ktp'));
            $img->resize(521, null,  function ($constraint)
            {
                $constraint->aspectRatio();
            });
            $filename = time().'.'.$request->file('photo_ktp')->getClientOriginalExtension();
            $img_path = 'user_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $user->photo_ktp = $img_path;
        }


        $user->save();
        $properti_id = Properti::where('id', $request->properti_id)->first();
        if($properti_id){
            $properti_id -> penghuni_id = $user->id;
            $properti_id -> save();
        }
        return redirect()->route('user');
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
        $user->status_penghuni = $request->status_penghuni;
        $user->user_status = 'pengguna';
        $user->status_penghuni = 'pemilik';

        if($request->hasFile('photo_identitas'))
        {
            // $file = $request->file('photo_identitas');
            // $extention = $file->getClientOriginalExtension();
            // $filename=time().'.'.$extention;
            // $file->move('user_photo',$filename);
            // $user->photo_identitas=$filename;
            $img = Image::make($request->file('photo_identitas'));
            $img->resize(521, null,  function ($constraint)
            {
                $constraint->aspectRatio();
            });
            $filename = time().'.'.$request->file('photo_identitas')->getClientOriginalExtension();
            $img_path = 'user_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $user->photo_identitas = $img_path;
        }

        if($request->hasFile('photo_ktp'))
        {
            // $file = $request->file('photo_identitas');
            // $extention = $file->getClientOriginalExtension();
            // $filename=time().'.'.$extention;
            // $file->move('user_photo',$filename);
            // $user->photo_identitas=$filename;
            $img = Image::make($request->file('photo_ktp'));
            $img->resize(521, null,  function ($constraint)
            {
                $constraint->aspectRatio();
            });
            $filename = time().'.'.$request->file('photo_ktp')->getClientOriginalExtension();
            $img_path = 'user_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $user->photo_ktp = $img_path;
        }
        $user->save();

        $properti = new Properti();
        $properti->alamat = $request-> alamat;
        $properti->no_rumah = $request-> no;
        $properti->no_listrik = $request->listrik;
        $properti->no_pam_bsd = $request->pam;
        $properti->RT = $request-> RT;
        $properti->RW = $request-> RW;
        $properti->lantai = $request->lantai;
        $properti->jumlah_kamar = $request->jumlah_kamar;
        $properti->luas_tanah = $request->luas_tanah; //ini luas kavling
        $properti->luas_bangunan = $request->luas_bangunan;
        // $properti->penghuni_id = $user->id;
        $properti->pemilik_id =  $user->id;
        $properti->status = $request->status;
        $properti->harga = $request->harga;

        $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', $request-> luas_tanah)->where('luas_kavling_akhir', '>=', $request-> luas_tanah)->first();
        // dd($ipkl);

        // $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', 12)->where('luas_kavling_akhir', '>=', 12)->first();


        $terkecil = tarif_ipkl::orderBy('luas_kavling_awal', 'asc')->first();
        $terbesar = tarif_ipkl::orderBy('luas_kavling_akhir', 'desc')->first();

        // dd($terbesar);

        if($ipkl == null){
            if($request->luas_tanah <= $terbesar && $request->luas_tanah <= $terkecil){
                $properti-> tarif_ipkl = $terkecil->tarif * $request->luas_tanah;
            }else if($request->luas_tanah >= $terbesar && $request->luas_tanah >= $terkecil){
                $properti-> tarif_ipkl = $terbesar->tarif * $request->luas_tanah;
            }
        }else if($ipkl != null){
            $properti->tarif_ipkl = $ipkl->tarif * $request-> luas_tanah;
        }



        $cluster = Cluster::where('id', $request->cluster_id)->first();
        // dd($cluster);
        if ($cluster === null) {
            // User does not exist
            $clus = new Cluster();
            $clus->name = $request->cluster_id;
            $clus->save();

            $properti->cluster_id = $clus->id;

        } else {
            $properti->cluster_id = $request->cluster_id;
        }


        $properti->save();
        // $properti->update(); belum bisa


        // $files = [];
        if($request->hasfile('image'))
         {
            foreach($request->file('image') as $file)
            {
                // $name = time().rand(1,100).'.'.$file->extension();
                // $file->move(public_path('files'), $name);
                // $files[] = $name;
                $img = Image::make($file);
                $img->resize(521, null,  function ($constraint)
                {
                    $constraint->aspectRatio();
                });

                $filename = time().rand(1,100).'.'.$file->getClientOriginalExtension();
                $img_path = 'properti_photo/'.$filename;
                Storage::put($img_path, $img->encode());

                $file= new Properti_image();
                $file->properti_id = $properti->id;
                $file->image = $img_path;
                $file->save();
            }
         }



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
        // if($request->hasFile('photo_identitas'))
        // {

        //     $destination = public_path().'/user_photo/'.$user->photo_identitas;
        //     $identitas = $user->photo_identitas;
        //     dd($identitas);
        //     if($identitas == null){
        //         $file = $request->file('photo_identitas');
        //         $extention = $file->getClientOriginalExtension();
        //         $filename=time().'.'.$extention;
        //         $file->move('user_photo',$filename);
        //         $user->photo_identitas=$filename;
        //     }
        //     else if(File::exists($destination))
        //     {
        //         unlink($destination);

        //     }
        //     $file = $request->file('photo_identitas');
        //         $extention = $file->getClientOriginalExtension();
        //         $filename=time().'.'.$extention;
        //         $file->move('user_photo',$filename);
        //         $user->photo_identitas=$filename;
        // }
        if ($request->hasFile('photo_identitas')) {
            Storage::disk('public')->delete($user->photo_identitas);
            $img = Image::make($request->file('photo_identitas'));
            $img->resize(521, null,  function ($constraint)
            {
                $constraint->aspectRatio();
            });
            // dd($img);
            $filename = time().'.'.$request->file('photo_identitas')->getClientOriginalExtension();
            $img_path = 'user_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $user->photo_identitas = $img_path;
        }

        if ($request->hasFile('photo_ktp')) {
            Storage::disk('public')->delete($user->photo_ktp);
            $img = Image::make($request->file('photo_ktp'));
            $img->resize(521, null,  function ($constraint)
            {
                $constraint->aspectRatio();
            });
            // dd($img);
            $filename = time().'.'.$request->file('photo_ktp')->getClientOriginalExtension();
            $img_path = 'user_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $user->photo_ktp = $img_path;
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
            // $image_path = public_path().'/user_photo/'.$user->photo_identitas;
            // unlink($image_path);
            Storage::delete($user->photo_identitas);
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
        // $penghuni = PenghuniDetail::with('user')->where('properti_id', $id)->first();
        // dd($penghuni);
        // $listing = Listing::findOrFail($id);
        // dd($listing);
        return view('pages.properti.detail',['properti' => $properti, 'image' =>$image]);
    }

    public function addPenghuni(){
        return view('pages.user.addpenghuni');
    }

    public function profile($id){
        $user = User::findOrFail($id);
        return view('pages.user.profile', ['user' => $user]);
    }


    public function getNomerid($id)
    {
        $nomer = Properti::where('cluster_id', $id)->get();
        $html   = '';
        foreach($nomer as $data){
            $html .= '<option value="'.$data['id'].'">'.$data['no_rumah'].'</option>';
        }
        echo $html;
        // return response()->json($Listing);
    }

    public function daftarUser(){
        $user= User::where('user_status', 'pengguna')->get();
        return response()->json($user);
    }

    public function updatePenghuni($id, Request $request){
        $properti = Properti::where('id', $id)->first();
        // dd($request->all());
        $properti->penghuni_id = $request-> user_id;
        $properti->save();
        // dd($properti);
        return redirect('/properti/detail/'.$id);
    //    dd( $properti->penghuni_id);
    }
}
