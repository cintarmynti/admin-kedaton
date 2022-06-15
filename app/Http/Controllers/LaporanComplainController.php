<?php

namespace App\Http\Controllers;

use App\Exports\ComplainExport;
use App\Models\Complain;
use App\Models\complain_image;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Kutia\Larafirebase\Facades\Larafirebase;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;



class LaporanComplainController extends Controller
{
    public function index(Request $request){
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $complain = Complain::with('user')->orderBy('created_at', 'desc');
        // dd($complain->id);

        if($request -> start_date){
            $complain->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }

        if($request -> status){
            $complain -> where('status', $request->status);
        }
        return view('pages.laporan complain.index', ['complain' => $complain->get()]);
    }

    public function create(){
        $user = User::where('user_status', 'pengguna')->get();
        return view('pages.laporan complain.create', ['user'=>$user]);
    }

    public function export_excel(Request $request)
	{
        if(!$request->start_date){
            $from = '';
        }else{
            $from = Carbon::parse($request->start_date);
        }

        if(!$request->end_date){
            $to = '';
        }else{
            $to = Carbon::parse($request->end_date);
        }
        $status = $request->status;
		return Excel::download(new ComplainExport($from, $to, $status), 'complain'.$from.'-'.$to.'.xlsx');
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
        $image = complain_image::where('complain_id', $id)->get();
        // dd($complain->id);
        $user = User::where('user_status', 'pengguna')->get();
        return view('pages.laporan complain.edit', ['complain' => $complain, 'user' => $user, 'image' => $image]);

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
            Alert::success('Data berhasil diupdate');
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

    public function imgdelete($id){
        $image = complain_image::findOrFail($id);
        // dd($image->image);

            // $image_path = public_path().'/complain_image/'.$image->image;
            Storage::delete($image->image);
        $image->delete();
        return redirect()->back();
    }

    public function delete($id){
        $post = Complain::findOrFail($id);
        $image = complain_image::where('complain_id', $post->id)->get();

        foreach($image as $img){

            Storage::delete($img->image);;
            $img->delete();
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

    public function updateStatus(Request $request){
        $status = Complain::where('id', $request->complain_id)->first();
        // dd($status);
        $status->status = $request->status;
        $status->save();

         if($request->status != 'diajukan'){
            $notifikasi = new Notifikasi();
            $notifikasi->type = 3;
            $notifikasi->user_id = $request->user_id;
            $notifikasi->sisi_notifikasi  = 'pengguna';
            $notifikasi->heading = 'STATUS COMPLAIN TELAH DIPERBARUI ADMIN';
            if($request->status == 'diproses'){
                $notifikasi->desc = 'Complain anda sedang diproses';

                // $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

                $fcmTokens = User::where('id', $request->user_id)->first()->fcm_token;
                 larafirebase::withTitle('STATUS COMPLAIN TELAH DIPERBARUI ADMIN')
                ->withBody('Complain anda sedang diproses')
                // ->withImage('https://firebase.google.com/images/social.png')
                ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
                ->withClickAction('admin/notifications')
                ->withPriority('high')
                ->withAdditionalData([
                    'halo' => 'isinya',
                ])
                ->sendNotification($fcmTokens);

            }else if($request->status == 'selesai'){
                $notifikasi->desc = 'Complain anda telah diselesaikan';

                $fcmTokens = User::where('id', $request->user_id)->first()->fcm_token;

                 larafirebase::withTitle('STATUS COMPLAIN TELAH DIPERBARUI ADMIN')
                ->withBody('Complain anda telah diselesaikan')
                // ->withImage('https://firebase.google.com/images/social.png')
                ->withIcon('https://seeklogo.com/images/F/fiirebase-logo-402F407EE0-seeklogo.com.png')
                ->withClickAction('admin/notifications')
                ->withPriority('high')
                ->withAdditionalData([
                    'halo' => 'isinya',
                ])
                ->sendNotification($fcmTokens);
            }
            $notifikasi->save();
         }


        return redirect()->back();
    }

    public function complainDetail($id){
        $complain = Complain::find($id);
        return response()->json($complain);
    }
}
