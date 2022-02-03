<?php

namespace App\Http\Controllers;
use App\Models\Complain;
use App\Models\Listing;
use App\Models\User;
use App\Models\Renovasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $customer = User::where('user_status', 'pengguna')->count();
        $disewakan = Listing::where('status', 'disewakan')->count();
        $dijual = Listing::where('status', 'dijual')->count();
        // $renovasi_selesai = Renovasi::where('status', 'dijual')->count();
        $complain = Complain::all()->count();
        $renovasi_progress = Renovasi::where('status_renovasi', 0)->count();
        

        // dd($customer);
        return view('pages.dashboard', ['customer' => $customer, 'dijual' => $dijual, 'disewakan' => $disewakan, 'complain' => $complain]);
    }
}
