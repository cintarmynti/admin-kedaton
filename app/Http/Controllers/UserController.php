<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cluster;
use App\Models\Riwayat;
use App\Models\Properti;
use App\Models\Pembayaran;
use App\Exports\UserExport;
use App\Mail\KedatonNewMember;
use App\Mail\PasswordBaru;
use App\Models\Cancel;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use App\Models\penghuniDetail;
use Illuminate\Http\Request;
use App\Models\Properti_image;
use App\Models\tarif_ipkl;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('penghuni', 'pemilik')->where('user_status', 'pengguna')
            ->orderBy('id', 'desc')
            ->get();


        // $properti = Properti::where()
        return view('pages.user.index', ['users' => $users]);
    }

    public function storeProp(Request $request){
        // dd(request()->id);
        if (is_iterable($request->properti_id)) {
            foreach ($request->properti_id as $prop) {
                $properti = Properti::findOrFail($prop);
                $properti->pemilik_id = $request->user_id;
                $properti->save();
            }
        }

        return redirect('/user');
    }

    public function newProp($id, Request $request){
        $cluster = Cluster::all();
        $user = User::where('user_status', 'pengguna')->get();
        return view('pages.user.newProp', ['cluster' => $cluster, 'user' => $user]);
    }

    public function activated(Request $request){
        $pw = Str::random(8);
        // dd($request->penghuni_id);

        $user = User::where('id', $request->penghuni_id)->first();
        // dd($user);
        $user->email_pengajuan = 2;
        $user->password = Hash::make($pw);
        $user->status_penghuni = 'penghuni';
        $user->save();

        $details = [
            'recipient' => $user->email,
            'fromEmail' => 'coba@gmail.com',
            'nik' => $user->nik,
            'subject' => $pw
        ];

        Mail::to($details['recipient'])->send(new KedatonNewMember($details));
        $penghuni_pengajuan = Pengajuan::where('user_id', $request->penghuni_id)->first();
        // dd($penghuni_pengajuan);
        $properti= Properti::where('id', $penghuni_pengajuan->properti_id_penghuni)->first();

        // dd($properti);
        $properti->status_pengajuan_penghuni = 1;
        $properti->save();

        return redirect('/user');
    }

    public function export_excel()
    {
        return Excel::download(new UserExport, 'pengguna.xlsx');
    }

    public function create()
    {
        $cluster = Cluster::all();
        $user = User::where('user_status', 'pengguna')->get();
        return view('pages.user.create', ['cluster' => $cluster, 'user' => $user]);
    }

    public function storePenghuni(Request $request)
    {
        $request->validate([
            // 'name' => 'required',
            // 'password' => 'required|min:8',
            'nik' => 'required',
            // 'email' => 'required|email',
            // 'alamat' => 'required',
            // 'phone' => 'required',
        ]);

        $user = User::where('nik', $request->nik)->first();
        if (!$user) {
            $user = new User();
            $user->name = $request->name;
            $user->nik = $request->nik;
            $user->alamat = $request->alamat;
            $user->phone = $request->phone;
            // $user->email = $request->email;
            // $user->password = bcrypt($request->password);
            $user->status_penghuni = $request->status_penghuni;
            $user->user_status = 'pengguna';
            $user->status_penghuni = 'penghuni';
            if ($request->hasFile('photo_identitas')) {
                $img = Image::make($request->file('photo_identitas'));
                $img->resize(521, null,  function ($constraint) {
                    $constraint->aspectRatio();
                });
                $filename = time() . '.' . $request->file('photo_identitas')->getClientOriginalExtension();
                $img_path = 'user_photo/' . $filename;
                Storage::put($img_path, $img->encode());
                $user->photo_identitas = $img_path;
            }

            if ($request->hasFile('photo_ktp')) {
                // Storage::disk('public')->delete($user->photo_ktp);
                $img = Image::make($request->file('photo_ktp'));
                $img->resize(521, null,  function ($constraint) {
                    $constraint->aspectRatio();
                });
                // dd($img);
                $filename = time() . '.' . $request->file('photo_ktp')->getClientOriginalExtension();
                $img_ktp = 'user_photo_ktp/' . $filename;
                Storage::put($img_ktp, $img->encode());
                $user->photo_ktp = $img_ktp;
                // dd($img_path);
            }
            $user->save();


        }

        $properti_id = Properti::where('id', $request->properti_id)->first();
        if ($properti_id) {
            $properti_id->penghuni_id = $user->id;
            $properti_id->save();
        }

        $pengajuan = new Pengajuan();
        $pengajuan->user_id = $user->id; // penghuni yang diajukan   //atau user yg melakukan pengajuan kepemilikan rumah
        $pengajuan->properti_id_penghuni = $properti_id->id; //properti id yg diajukan dari ppenghuni
        $pengajuan->pemilik_mengajukan = $properti_id->pemilik_id; //id user yang mengajukan
        $pengajuan->status_verivikasi = 1; //id user yang mengajukan
        $pengajuan->save();

        $penghuni_detail = new penghuniDetail();
        $penghuni_detail->penghuni_id = $user->id;
        $penghuni_detail->properti_id = $properti_id->id;
        $penghuni_detail->save();

        return redirect()->route('user.rumah', $properti_id->id);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->nik = $request->nik;
        $user->alamat = $request->alamat;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status_penghuni = $request->status_penghuni;
        $user->user_status = 'pengguna';
        $user->status_penghuni = 'pemilik';

        if ($request->hasFile('photo_identitas')) {
            $img = Image::make($request->file('photo_identitas'));
            $img->resize(521, null,  function ($constraint) {
                $constraint->aspectRatio();
            });
            $filename = time() . '.' . $request->file('photo_identitas')->getClientOriginalExtension();
            $img_path = 'user_photo/' . $filename;
            Storage::put($img_path, $img->encode());
            $user->photo_identitas = $img_path;
        }

        if ($request->hasFile('photo_ktp')) {
            // Storage::disk('public')->delete($user->photo_ktp);
            $img = Image::make($request->file('photo_ktp'));
            $img->resize(521, null,  function ($constraint) {
                $constraint->aspectRatio();
            });
            // dd($img);
            $filename = time() . '.' . $request->file('photo_ktp')->getClientOriginalExtension();
            $img_ktp = 'user_photo_ktp/' . $filename;
            Storage::put($img_ktp, $img->encode());
            $user->photo_ktp = $img_ktp;
            // dd($img_path);
        }


        $user->save();

        if (is_iterable($request->properti_id)) {
            foreach ($request->properti_id as $prop) {
                $properti = Properti::findOrFail($prop);
                $properti->pemilik_id = $user->id;
                $properti->save();
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

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', ['user' => $user]);
    }

    public function detailJson($name)
    {
        // $user = User::whereNik($id)->first();
        $user=User::where('nik', $name)->get();

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->nik = $request->nik;
        $user->alamat = $request->alamat;
        $user->phone = $request->phone;
        // $user->password = bcrypt($request->password);
        $user->user_status = 'pengguna';

        if($user->email != $request->email){
            $user->email = $request->email;
            $pw = Str::random(8);
            // dd($pw);
            $hashed_random_password = Hash::make($pw);
            $user->password = $hashed_random_password;
            // dd($user->password);
            // $user->save();
            $details = [
                'recipient' => $request->email,
                // 'fromEmail' => 'coba@gmail.com',
                // 'nik' => $request->nik,
                'subject' => $pw
            ];

            Mail::to($details['recipient'])->send(new PasswordBaru($details));
            $user->update();

        }

        if($user->email == $request->email){
            $user->email = $request->email;
            // dd($user->email);
            $user->update();
        }


        if ($request->hasFile('photo_identitas')) {
            Storage::disk('public')->delete($user->photo_identitas);
            $img = Image::make($request->file('photo_identitas'));
            $img->resize(521, null,  function ($constraint) {
                $constraint->aspectRatio();
            });
            // dd($img);
            $filename = time() . '.' . $request->file('photo_identitas')->getClientOriginalExtension();
            $img_path = 'user_photo/' . $filename;
            Storage::put($img_path, $img->encode());
            $user->photo_identitas = $img_path;
        }

        // dd($request->all());

        if ($request->hasFile('photo_ktp')) {
            Storage::disk('public')->delete($user->photo_ktp);
            $img = Image::make($request->file('photo_ktp'));
            $img->resize(521, null,  function ($constraint) {
                $constraint->aspectRatio();
            });
            // dd($img);
            $filename = time() . '.' . $request->file('photo_ktp')->getClientOriginalExtension();
            $img_ktp = 'user_photo_ktp/' . $filename;
            Storage::put($img_ktp, $img->encode());
            $user->photo_ktp = $img_ktp;
            // dd($img_path);
        }

        // dd($user->photo_ktp);
        // dd($user);

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


    public function delete($id)
    {
        $user = User::find($id);
        // dd($user->photo_identitas);
        if ($user->photo_identitas != null) {
            // $image_path = public_path().'/user_photo/'.$user->photo_identitas;
            // unlink($image_path);
            Storage::delete($user->photo_identitas);
        }

        $user->delete();
        return redirect('/user');
    }

    public function show($id)
    {
        $properti = Properti::where('pemilik_id', $id)->orWhere('penghuni_id', $id)->get();
        // if ($properti == null) {
        //     $properti = Properti::where('penghuni_id', $id)->get();
        //     // dd($properti);
        // } else {
        //     $properti = Properti::where('pemilik_id', $id)->get();
        // }
        return view('pages.user.detail', [
            "properti" => $properti,
            "user" => User::find($id)
        ]);
    }

    public function detail_rumah($id)
    {
        $properti = Properti::with('penghuni', 'pemilik')->where('id', $id)->first();
        $image = Properti_image::where('properti_id', $id)->get();
        $riwayat_penghuni = penghuniDetail::where('properti_id', $id)->get();
        // $penghuni = PenghuniDetail::with('user')->where('properti_id', $id)->first();
        // dd($penghuni);
        // $listing = Listing::findOrFail($id);
        // dd($listing);
        return view('pages.properti.detail', ['properti' => $properti, 'image' => $image, 'penghuni'  => $riwayat_penghuni]);
    }

    public function addPenghuni($id)
    {
        $data['properti'] = Properti::find($id);
        $data['users'] = User::where('user_status', '!=', 'admin')
            ->get();

        return view('pages.user.addpenghuni', $data);
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.profile', ['user' => $user]);
    }


    public function getNomerid($id)
    {

        $cekNomer = Properti::where('cluster_id', $id)->where('pemilik_id', null)->first();
        if($cekNomer == null){
            $return['kosong'] = true;
            $return['status'] = 404;
            $return['data'] = '';
        }else {
            $nomer = Properti::where('cluster_id', $id)->where('pemilik_id', null)->get();
            $return['kosong'] = false;
            $return['status'] = 200;
            $return['data'] = $nomer;
            // $html   = '';
            // $html .= '<option value="">Pilih No Rumah</option>';
            // foreach ($nomer as $data) {
            //     $html .= '<option value="' . $data['id'] . '">' . $data['no_rumah'] . '</option>';
            // }

            // $return['opsi'] = $html;
            // echo $html;
        }
        return response()->json($return);


    }

    public function daftarUser()
    {
        $user = User::where('user_status', 'pengguna')->get();
        return response()->json($user);
    }

    public function updatePenghuni($id, Request $request)
    {
        $properti = Properti::where('id', $id)->first();
        // dd($request->all());
        $properti->penghuni_id = $request->user_id;
        $properti->save();
        // dd($properti);
        return redirect('/properti/detail/' . $id);
        //    dd( $properti->penghuni_id);
    }

    public function detail_penghuni(Request $request)
    {
        $penghuni = Pengajuan::with('user', 'user_pemilik')->where('user_id', $request->id)->first();
        return response()->json($penghuni);
    }

    public function canceled(Request $request){
        $user = User::where('id', $request->penghuni_id2)->first();
        $user->delete();

        // $cancel = new Cancel();
        // $cancel->alasan_dibatalkan = $request->alasan_dibatalkan;
        // $cancel->pemilik_mengajukan_id = $request->pemilik_id2;
        // $cancel->save();

        $notifikasi = new Notifikasi();
        $notifikasi->user_id = $request->pemilik_id2;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'PENDAFTARAN PENGHUNI BARU DITOLAK';
        $notifikasi->desc = 'Mohon Maaf, pedaftaran penghuni baru kami tolak kaena '.$request->alasan_dibatalkan;
        $notifikasi->save();

        return redirect('/user');
        // dd($cancel);
    }
}
