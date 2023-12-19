<?php

namespace App\Http\Controllers;

use App\Exports\PropertiExport;
use DB;
use App\Models\User;
use App\Models\Cluster;
use App\Models\IPKL;
use App\Models\Listing;
use App\Models\Properti;
use App\Models\tarif_ipkl;
use Illuminate\Http\Request;
use App\Models\listing_image;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use App\Models\penghuniDetail;
use App\Models\Properti_image;
use App\Models\Tagihan;
use Illuminate\Support\Facades\DB as FacadesDB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Kutia\Larafirebase\Facades\Larafirebase;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Console\Input\Input;
use Maatwebsite\Excel\Facades\Excel;



class PropertiController extends Controller
{
    public function index(Request $request){

        $properti = DB::table('properti')
            ->leftJoin('cluster', 'properti.cluster_id', '=', 'cluster.id')
            ->leftJoin('users as penghuni', 'properti.penghuni_id', '=', 'penghuni.id')
            ->leftJoin('users as pemilik', 'properti.pemilik_id', '=', 'pemilik.id')
            ->select(
                'properti.*',
                'cluster.id as cluster_id',
                'cluster.name as cluster_name',
                'penghuni.id as penghuni_id', // Memberikan alias 'penghuni_id' untuk kolom 'id' di tabel 'users' sebagai penghuni
                'penghuni.name as penghuni_name',
                'pemilik.id as pemilik_id', // Memberikan alias 'pemilik_id' untuk kolom 'id' di tabel 'users' sebagai pemilik
                'pemilik.name as pemilik_name'
            )
            ->get();


            if($request -> harga){
                // dd("masuk");
                $hargaThreshold = $request -> harga;
                $result = DB::select("
                SELECT
                    properti.*,
                    cluster.name AS cluster_name,
                    penghuni.name AS penghuni_name,
                    pemilik.name AS pemilik_name
                FROM properti
                LEFT JOIN cluster ON properti.cluster_id = cluster.id
                LEFT JOIN users AS penghuni ON properti.penghuni_id = penghuni.id
                LEFT JOIN users AS pemilik ON properti.pemilik_id = pemilik.id
                WHERE properti.id IN (
                    SELECT properti_id
                    FROM rev_listing
                    WHERE harga < :hargaThreshold
                )
            ", ['hargaThreshold' => $hargaThreshold]);

            // dd($result);
            return view('pages.properti.index', ['properti' => $result]);
            }




            // dd($properti);
            return view('pages.properti.index', ['properti' => $properti]);

    }

    public function ceknomer($id, $name){
        $user=Properti::where('cluster_id', $id)->where('no_rumah', $name)->first();
        return response()->json($user);
    }

    public function update_penghuni(Request $request){
        $properti = Properti::find($request->properti_id);
        $properti->penghuni_id = $request->penghuni_id;
        $properti->status_pengajuan_penghuni = 2;
        $properti->save();

        $pengajuan = Pengajuan::where('user_id', $request->penghuni_id)->where('pemilik_mengajukan', $request->pemilik_id)->where('properti_id_penghuni', $request->properti_id)->first();
        $pengajuan->status_verivikasi = 1;
        $pengajuan->save();

        $penghuni_detail = new penghuniDetail();
        $penghuni_detail->penghuni_id = $request->penghuni_id;
        $penghuni_detail->properti_id = $request->properti_id;
        $penghuni_detail->save();


        $notifikasi = new Notifikasi();
        $notifikasi -> type = 7;
        $notifikasi->user_id = $request->pemilik_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'PENGHUNI TELAH DISETUJUI';
        $notifikasi->desc = 'Admin telah menyetujui penyewaan properti tersebut';
        $notifikasi->save();



        $fcmTokens = User::where('id', $request->pemilik_id)->first()->fcm_token;
        // $fcmTokens = User::where('id', 29)->first()->fcm_token;
        // dd($fcmTokens);
        larafirebase::withTitle('PENGHUNI TELAH DISETUJUI')
        ->withBody('Admin telah menyetujui penyewaan properti tersebut')
        // ->withImage('https://firebase.google.com/images/social.png')
        ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
        ->withClickAction('admin/notifications')
        ->withPriority('high')
        ->withAdditionalData([
            'halo' => 'isinya',
        ])
    ->sendNotification($fcmTokens);

        return redirect()->route('properti');
    }

    public function tolak_tambahproperti(Request $request)
    {
        $pengajuan = Pengajuan::where('user_id', $request->pemilik_id)->where('properti_id', $request->properti_id)->first();
        $pengajuan->delete();

        $properti = Properti::where('id', $request->properti_id)->first();
        $properti -> status_pengajuan = 0;
        $properti -> save();

        $notifikasi = new Notifikasi();
        $notifikasi -> type = 4;
        $notifikasi->user_id = $request->pemilik_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'PENGAJUAN TAMBAH PROPERTI INI DITOLAK';
        $notifikasi->desc = 'Mohon Maaf, pengajuan Tambah Properti baru pada properti kami tolak karena '.$request->alasan_dibatalkan;
        $notifikasi->save();

        $fcmTokens = User::where('id', $request->pemilik_id)->first()->fcm_token;

        // $fcmTokens = User::where('id', 29)->first()->fcm_token;
        // dd($fcmTokens);
        larafirebase::withTitle('PENGAJUAN TAMBAH PROPERTI INI DITOLAK')
        ->withBody('Mohon Maaf, pengajuan Tambah Properti baru pada properti kami tolak karena '.$request->alasan_dibatalkan)
        // ->withImage('https://firebase.google.com/images/social.png')
        ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
        ->withClickAction('admin/notifications')
        ->withPriority('high')
        ->withAdditionalData([
            'halo' => 'isinya',
        ])
    ->sendNotification($fcmTokens);

        return redirect()->back();

    }

    public function tolak_penghuni(Request $request)
    {
        $pengajuan = Pengajuan::where('user_id', $request->penghuni_id)->where('pemilik_mengajukan', $request->pemilik_id)->where('properti_id_penghuni', $request->properti_id)->first();
        $pengajuan->delete();

        $properti = Properti::where('id', $request->properti_id)->first();
        $properti -> status_pengajuan_penghuni = 0;
        $properti -> save();

        $notifikasi = new Notifikasi();
        $notifikasi ->type = 7;
        $notifikasi->user_id = $request->pemilik_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'PENGAJUAN PENGHUNI UNTUK PROPERTI INI DITOLAK';
        $notifikasi->desc = 'Mohon Maaf, pengajuan penghuni baru pada properti kami tolak karena '.$request->alasan_dibatalkan;
        $notifikasi->save();

        $fcmTokens = User::where('id', $request->pemilik_id)->first()->fcm_token;

        // $fcmTokens = User::where('id', 29)->first()->fcm_token;
        // dd($fcmTokens);
        larafirebase::withTitle('PENGAJUAN PENGHUNI UNTUK PROPERTI INI DITOLAK')
        ->withBody('Mohon Maaf, pengajuan penghuni baru pada properti kami tolak karena '.$request->alasan_dibatalkan)
        // ->withImage('https://firebase.google.com/images/social.png')
        ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
        ->withClickAction('admin/notifications')
        ->withPriority('high')
        ->withAdditionalData([
            'halo' => 'isinya',
        ])
    ->sendNotification($fcmTokens);

        return redirect()->back();
    }

    public function penghuni($id)
    {
        $properti = Pengajuan::where('properti_id_penghuni', $id)->orderBy('id', 'desc')->first();
        // dd($properti);
        $user['penghuni'] = User::where('id', $properti->user_id)->first();
        $user['pemilik'] = $properti->pemilik_mengajukan;
        return response()->json($user);
    }

    public function update_pemilik(Request $request)
    {
        $properti = Properti::find($request->properti_id);
        $properti->pemilik_id = $request->pemilik_id;
        $properti->status_pengajuan = 2;
        $properti->save();

        $pengajuan = Pengajuan::where('user_id', $request->pemilik_id)->where('properti_id', $request->properti_id)->first();
        $pengajuan -> status_verivikasi = 1;
        $pengajuan->save();

        $notifikasi = new Notifikasi();
        $notifikasi -> type = 4;
        $notifikasi->user_id = $request->pemilik_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'PENAMBAHAN PROPERTI BARU TELAH DISETUJUI';
        $notifikasi->desc = 'Properti anda telah disetujui';
        $notifikasi->save();

        $fcmTokens = User::where('id', $request->pemilik_id)->first()->fcm_token;

        // $fcmTokens = User::where('id', 29)->first()->fcm_token;
        // dd($fcmTokens);
        larafirebase::withTitle('PENAMBAHAN PROPERTI BARU TELAH DISETUJUI')
        ->withBody('Properti anda telah disetujui')
        // ->withImage('https://firebase.google.com/images/social.png')
        ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
        ->withClickAction('admin/notifications')
        ->withPriority('high')
        ->withAdditionalData([
            'halo' => 'isinya',
        ])
    ->sendNotification($fcmTokens);


        return redirect()->route('properti');
    }

    public function create()
    {
        $cluster = Cluster::all();
        $user = User::where('user_status', 'pengguna')->get();
        return view('pages.properti.create', ['user' => $user, 'cluster' => $cluster]);
    }

    public function export_excel()
    {
        return Excel::download(new PropertiExport, 'properti.xlsx');
    }

    public function datauser($id)
    {
        $properti = Pengajuan::where('properti_id', $id)->first();
        $user = User::where('id', $properti->user_id)->first();

        return response()->json($user);
    }

    public function store(Request $request)
    {
        $properti = new Properti();
        $properti->alamat = $request->alamat;
        $properti->no_rumah = $request->no;
        $properti->no_listrik = $request->listrik;
        $properti->no_pam_bsd = $request->pam;
        $properti->RT = $request->RT;
        $properti->RW = $request->RW;
        $properti->lantai = $request->lantai;
        $properti->jumlah_kamar = $request->jumlah_kamar;
        $properti->luas_tanah = $request->luas_tanah; //ini luas kavling
        $properti->luas_bangunan = $request->luas_bangunan;
        $properti->kamar_mandi = $request->kamar_mandi;
        $properti->carport = $request->carport;
        $properti->provinsi_id = $request->provinsi_id;
        $properti->provinsi = $request->provinsi;
        $properti->kabupaten_id = $request->kabupaten_id;
        $properti->kabupaten = $request->kabupaten;
        $properti->kecamatan_id = $request->kecamatan_id;
        $properti->kecamatan = $request->kecamatan;
        $properti->kelurahan_id = $request->kelurahan_id;
        $properti->kelurahan = $request->kelurahan;
        $properti->status_pengajuan = 2;

        // $properti->penghuni_id = $request->penghuni;
        // $properti->pemilik_id = $request->pemilik;
        $properti->status = $request->status;
        // $properti->harga = $request->harga;

        $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', $request->luas_tanah)->where('luas_kavling_akhir', '>=', $request->luas_tanah)->first();
        // dd($ipkl);

        // $ipkl = tarif_ipkl::where('luas_kavling_awal', '<=', 12)->where('luas_kavling_akhir', '>=', 12)->first();


        $terkecil = tarif_ipkl::orderBy('luas_kavling_awal', 'asc')->first();
        $terbesar = tarif_ipkl::orderBy('luas_kavling_akhir', 'desc')->first();

        // dd($terbesar);

        if ($ipkl == null) {
            if ($request->luas_tanah <= $terbesar && $request->luas_tanah <= $terkecil) {
                $properti->tarif_ipkl = $terkecil->tarif * $request->luas_tanah;
            } else if ($request->luas_tanah >= $terbesar && $request->luas_tanah >= $terkecil) {
                $properti->tarif_ipkl = $terbesar->tarif * $request->luas_tanah;
            }
        } else if ($ipkl != null) {
            $properti->tarif_ipkl = $ipkl->tarif * $request->luas_tanah;
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
        if ($request->hasfile('image')) {
            foreach ($request->file('image') as $file) {
                // $name = time().rand(1,100).'.'.$file->extension();
                // $file->move(public_path('files'), $name);
                // $files[] = $name;
                $img = Image::make($file);
                $img->resize(521, null,  function ($constraint) {
                    $constraint->aspectRatio();
                });

                $filename = time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $img_path = 'properti_photo/' . $filename;
                Storage::put($img_path, $img->encode());

                $file = new Properti_image();
                $file->properti_id = $properti->id;
                $file->image = $img_path;
                $file->save();
            }
        }


        if ($properti) {
            Alert::success('Data berhasil disimpan');

            return redirect()
                ->route('properti')
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

    public function detail($id)
    {
        $properti = Properti::with('penghuni', 'pemilik', 'cluster')->where('id', $id)->first();
        // dd($properti);
        $image = Properti_image::where('properti_id', $id)->get();
        // $listing = Listing::findOrFail($id);
        // dd($listing);
        $riwayat_penghuni = penghuniDetail::where('properti_id', $id)->get();
        // dd($riwayat_penghuni);
        return view('pages.properti.detail', ['properti' => $properti, 'image' => $image, 'penghuni' => $riwayat_penghuni]);
    }

    public function detailJson($id)
    {
        $data['properti'] = Properti::with('penghuni', 'pemilik', 'cluster')->where('id', $id)->first();
        $data['image'] = Properti_image::where('properti_id', $id)->get();

        // dd($data['properti']);
        return response()->json($data);
    }
    public function edit($id)
    {
        $properti = Properti::findOrFail($id);
        $user = User::where('user_status', 'pengguna')->get();
        $cluster = Cluster::all();
        $image = properti_image::where('properti_id', $id)->get();
        return view('pages.properti.edit', ['properti' => $properti, 'user' => $user, 'cluster' => $cluster, 'image' => $image]);
    }

    public function imgdelete($id)
    {
        $image = Properti_image::findOrFail($id);
        Storage::delete($image->image);
        $image->delete();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $properti = properti::findOrFail($id);
        $properti->alamat = $request->alamat;
        $properti->no_rumah = $request->no;
        $properti->no_listrik = $request->listrik;
        $properti->no_pam_bsd = $request->pam;
        $properti->RT = $request->RT;
        $properti->RW = $request->RW;
        $properti->lantai = $request->lantai;
        $properti->jumlah_kamar = $request->jumlah_kamar;
        $properti->kamar_mandi = $request->kamar_mandi;
        $properti->carport = $request->carport;
        $properti->luas_tanah = $request->luas_tanah;
        $properti->luas_bangunan = $request->luas_bangunan;
        // $properti->penghuni_id = $request->penghuni;
        // $properti->pemilik_id = $request->pemilik;
        $properti->status = $request->status;
        // $properti->harga = $request->harga;
        $properti->provinsi_id = $request->provinsi_id;
        $properti->provinsi = $request->provinsi;
        $properti->kabupaten_id = $request->kabupaten_id;
        $properti->kabupaten = $request->kabupaten;
        $properti->kecamatan_id = $request->kecamatan_id;
        $properti->kecamatan = $request->kecamatan;
        $properti->kelurahan_id = $request->kelurahan_id;
        $properti->kelurahan = $request->kelurahan;
        $properti->status_pengajuan = 2;


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

        $properti->update();

        if ($request->hasfile('image')) {

             foreach($request->file('image') as $file) {
                // $name = time().rand(1,100).'.'.$file->extension();
                // $file->move(public_path('files'), $name);
                // $files[] = $name;
                $img = Image::make($file);
                $img->resize(521, null,  function ($constraint) {
                    $constraint->aspectRatio();
                });

                $filename = time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $img_path = 'properti_photo/' . $filename;
                Storage::put($img_path, $img->encode());

                $file = new Properti_image();
                $file->properti_id = $properti->id;
                $file->image = $img_path;
                $file->save();
            }
        }

        if ($properti) {
            Alert::success('Data berhasil diupdate');
            return redirect()
                ->route('properti')
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
        $properti = Properti::findOrFail($id);
        $image = Properti_image::where('properti_id', $properti->id)->get();

        foreach ($image as $img) {
            $img->delete();
            Storage::delete($img->image);
        }
        $properti->delete();

        if ($properti) {
            return redirect()
                ->route('properti')
                ->with([
                    'success' => 'Properti has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('properti')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }

    public function riwayat($id)
    {
        $properti = Tagihan::with('ipkl')->where('properti_id', $id)->where('status', 2)->get();
        //    dd($properti);
        return view('pages.properti.riwayat',  ['riwayat_ipkl' => $properti]);
    }


}
