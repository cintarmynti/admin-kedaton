<?php

namespace App\Http\Controllers;

use App\Exports\TagihanExport;
use App\Models\IPKL;
use App\Models\Cluster;
use App\Models\Listing;
use App\Models\Notifikasi;
use App\Models\Properti;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use App\Models\Rumah;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Kutia\Larafirebase\Facades\Larafirebase;
use Maatwebsite\Excel\Facades\Excel;

class IPKLController extends Controller
{
    public function index(Request $request)
    {
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $query = Tagihan::with('nomer', 'cluster')->orderby('created_at', 'desc');
        // dd($start_date);

        if ($request->start_date) {
            $query->whereBetween('periode_pembayaran', [$start_date, $end_date]);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return view('pages.ipkl.index', ['ipkl' => $query->get()]);
    }

    public function pembayaran_baru($id){
        $user_prop = User::find($id);
        $properti = Properti::where('pemilik_id', $user_prop->id)->orWhere('penghuni_id')->get();
        $query = [];
        foreach($properti as $p){
            $push_properti = Tagihan::where('properti_id', $p->id)->where('status', 2)->get();
            foreach ($push_properti as $key => $properti) {
                array_push($query, $properti);
            }
        }
        return view('pages.ipkl.index', ['ipkl' => $query]);

    }

    public function getIPKLid($id)
    {
        $listing = Properti::where('cluster_id', $id)->get();
        $html   = '';
        foreach ($listing as $data) {
            $html .= '<option value="' . $data['id'] . '">' . $data['no_rumah'] . '</option>';
        }
        echo $html;
        // return response()->json($Listing);
    }

    public function getIPKLharga($id)
    {
        $listing = Properti::findOrFail($id);
        $html   = '';
        $html .= $listing['tarif_ipkl'];
        echo $html;
        // return response()->json($Listing);
    }

    public function export_excel(Request $request)
    {
        if (!$request->start_date) {
            $from = '';
        } else {
            $from = Carbon::parse($request->start_date);
        }

        if (!$request->end_date) {
            $to = '';
        } else {
            $to = Carbon::parse($request->end_date);
        }
        $status = $request->status;

        return Excel::download(new TagihanExport($from, $to, $status), 'Tagihan' . $from . '-' . $to . '.xlsx');
    }

    public function create()
    {
        $nomer = Properti::all();
        $cluster = Cluster::all();
        return view('pages.ipkl.create', ['nomer' => $nomer, 'cluster' => $cluster]);
    }

    public function store(Request $request)
    {
        $cekTagihan = Tagihan::whereMonth('periode_pembayaran', Carbon::parse($request->periode_pembayaran))->whereYear('periode_pembayaran', Carbon::parse($request->periode_pembayaran))->where('properti_id', $request->properti_id)->first();
        if ($cekTagihan != null) {
            return redirect()->back()->withErrors(['msg' => 'tagihan properti untuk periode tersebut sudah ada']);
        }
        $ipkl = new Tagihan();
        $ipkl->cluster_id = $request->cluster_id;
        $ipkl->properti_id = $request->properti_id;
        $ipkl->periode_pembayaran = $request->periode_pembayaran;
        $ipkl->jumlah_pembayaran = str_replace(',', '',$request->jumlah_pembayaran);
        $ipkl->status = 1;
        $ipkl->type_id = 1;
        $ipkl->save();

        $properti = Properti::where('id', $request->properti_id)->first();
        // dd($properti->penghuni_id);
        if ($properti->pemilik_id != null) {
            $notifikasi = new Notifikasi();
            $notifikasi->user_id = $properti->pemilik_id;
            $notifikasi->sisi_notifikasi  = 'pengguna';
            $notifikasi->heading = 'ADA PEMBAYARAN IPKL BARU';
            $notifikasi->desc = 'sudah ada tagihan pembayaran ipkl baru, jangan lupa membayar ya';
            $notifikasi->save();
        }

        if ($properti->penghuni_id != null) {
            $notifikasi = new Notifikasi();
            $notifikasi->user_id = $properti->penghuni_id;
            $notifikasi->sisi_notifikasi  = 'pengguna';
            $notifikasi->heading = 'ADA PEMBAYARAN IPKL BARU';
            $notifikasi->desc = 'sudah ada tagihan pembayaran ipkl baru, jangan lupa membayar ya';
            $notifikasi->save();
        }

        return redirect('/ipkl');
    }

    public function generate_tagihan()
    {
        $sekarang = Carbon::now()->format('d');
        // dd($sekarang);
        if ($sekarang == '25') {
            $cekTagihan = Tagihan::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

            // dd(count($cekTagihan));
            if (count($cekTagihan) == 0) {
                $properti = Properti::whereNotNull('pemilik_id')->get();

                foreach ($properti as $p) {
                    $cekTagihanproperti = Tagihan::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('properti_id', $p->id)->first();

                    // dd($cekTagihanproperti);

                    if ($cekTagihanproperti == null) {
                        $tagihan = new Tagihan();
                        $tagihan->cluster_id = $p->cluster_id;
                        $tagihan->properti_id = $p->id;
                        $tagihan->periode_pembayaran = Carbon::now();
                        $tagihan->jumlah_pembayaran = $p->tarif_ipkl;
                        $tagihan->type_id = 1;
                        $tagihan->status = 1;
                        $tagihan->save();

                        if ($p->pemilik_id != null) {
                            $notifikasi = new Notifikasi();
                            $notifikasi->user_id = $p->pemilik_id;
                            $notifikasi->sisi_notifikasi  = 'pengguna';
                            $notifikasi->heading = 'ADA PEMBAYARAN IPKL BARU';
                            $notifikasi->desc = 'sudah ada tagihan pembayaran ipkl baru, jangan lupa membayar ya';
                            $notifikasi->save();
                        }

                        if ($p->penghuni_id != null) {
                            $notifikasi = new Notifikasi();
                            $notifikasi->user_id = $p->penghuni_id;
                            $notifikasi->sisi_notifikasi  = 'pengguna';
                            $notifikasi->heading = 'ADA PEMBAYARAN IPKL BARU';
                            $notifikasi->desc = 'sudah ada tagihan pembayaran ipkl baru, jangan lupa membayar ya';
                            $notifikasi->save();
                        }
                    }
                }
            } else {
                dd('tidak ada tagihan');
            }
        }
    }

    public function edit($id)
    {
        $ipkl = IPKL::findOrFail($id);
        return view('pages.ipkl.edit', ['ipkl' => $ipkl]);
    }

    public function update(Request $request, $id)
    {
        $ipkl = IPKL::findOrFail($id);
        $ipkl->rumah_id = $request->rumah_id;
        $ipkl->metode_pembayaran = $request->metode_pembayaran;
        $ipkl->periode_pembayaran = $request->periode_pembayaran;
        $ipkl->jumlah_pembayaran = $request->jumlah_pembayaran;
        $ipkl->status = $request->status;
        $ipkl->update();

        return redirect('/ipkl');
    }

    public function status($id)
    {
        $data = IPKL::findOrFail($id);
        // dd($status_id);
        $status_sekarang = $data->status;
        if ($status_sekarang == 1) {
            IPKL::where('id', $id)->update([
                'status' => 2
            ]);
        }
        return redirect('/ipkl');
    }

    public function delete($id)
    {
        $ipkl = IPKL::findOrFail($id);
        $ipkl->delete();
        return redirect('/ipkl');
    }

    public function get_riwayat($id)
    {

        $cancel = IPKL::findOrFail($id);
        return response()->json($cancel);
    }

    public function create_riwayat(Request $request)
    {
        // dd($request->all());

        $notifikasi = new Notifikasi();
        $notifikasi->user_id = $request->user_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'PEMBAYARAN IPKL TELAH DISETUJUI';
        $notifikasi->desc = 'Pembayaran IPKL telah disetujui admin, terimakasih sudah membayar';
        $notifikasi->save();

        try{
            $fcmTokens = User::where('id', $request->user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            Larafirebase::withTitle($request->title = 'PEMBAYARAN IPKL TELAH DISETUJUI')
                ->withBody($request->message = 'Pembayaran IPKL telah disetujui admin, terimakasih sudah membayar')
                ->sendMessage($fcmTokens);

            return response()->json(['success'=>'Notification Sent Successfully!!']);

        }catch(\Exception $e){
            report($e);
            return response()->json(['error'=>'Something goes wrong while sending notification.']);
        }
        // Alert::success('Data berhasil disimpan');

        $data = IPKL::findOrFail($request->pembayaran_id);
        // dd($status_id);
        $status_sekarang = $data->status;
        if ($status_sekarang == 1) {
            IPKL::where('id', $request->pembayaran_id)->update([
                'status' => 2
            ]);
            Tagihan::where('id', $request->tagihan_id)->update([
                'status' => 3
            ]);
        }
        return redirect('/ipkl');
        // return redirect('/ipkl');
    }

    public function pembayar($id)
    {
        $ipkl = IPKL::with('user')->where('tagihan_id', $id)->get();
        return view('pages.ipkl.detail', ['ipkl' => $ipkl]);
    }

    public function penolakan_pembayaran(Request $request)
    {
        $tagihan = Tagihan::where('id', $request->tagihan_id)->first();
        $tagihan->status = 1;
        $tagihan->save();

        $ipkl = IPKL::where('tagihan_id', $request->tagihan_id)->first();
        $ipkl->delete();

        $notifikasi = new Notifikasi();
        $notifikasi->user_id = $request->user_id;
        $notifikasi->sisi_notifikasi  = 'pengguna';
        $notifikasi->heading = 'Pembayaran IPKL anda ditolak';
        $notifikasi->desc = 'pembayaran ipkl anda ditolak karena'.$request->alasan_penolakan;
        $notifikasi->save();

        return redirect('/ipkl');
    }
}
