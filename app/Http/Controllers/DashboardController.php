<?php

namespace App\Http\Controllers;
use App\Models\Complain;
use App\Models\Notifikasi;
use App\Models\PanicButton;
use App\Models\rev_listing;
use App\Models\User;
use App\Models\Renovasi;
// use App\Models\rev_listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $customer = User::where('user_status', 'pengguna')->count();
        $disewakan = rev_listing::where('status', 'disewa')->count();
        $dijual = rev_listing::where('status', 'dijual')->count();
        // $renovasi_selesai = Renovasi::where('status', 'dijual')->count();
        $complain = Complain::all()->count();
        $renovasi_progress = Renovasi::where('status_renovasi', 0)->count();

        // $panic = PanicButton::with('properti')->where('status_keterangan', 'not checked')->get();
        // dd($panic);

        $panic = DB::table('panic_button')
        ->join('properti', 'properti.id', '=', 'panic_button.id_rumah')
        ->join('cluster', 'cluster.id', '=', 'properti.cluster_id')
        ->select('panic_button.id', 'name', 'no_rumah')
        ->where('status_keterangan', 'not checked')->get();
        // dd($panic);
        // dd($customer);

        $total_panic = $panic->count();

        return view('pages.dashboard', ['customer' => $customer, 'dijual' => $dijual, 'disewakan' => $disewakan, 'complain' => $complain, 'panic' => $panic, 'total' => $total_panic]);
    }

    public function notif_admin(){
        $notif['jumlah'] = Notifikasi::where('sisi_notifikasi', 'admin')->where('status_dibaca', 1)->get()->count();
        $notif['data'] = Notifikasi::where('sisi_notifikasi', 'admin')->orderBy('created_at', 'desc')->get();
        return response()->json($notif);
    }
}
