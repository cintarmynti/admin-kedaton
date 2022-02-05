<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rumah;
use App\Models\Cluster;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use RealRashid\SweetAlert\Facades\Alert;

class RumahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rumah = Rumah::with('user','nomer_rumah')->get();
        return view('pages.rumah_pengguna.index',[
            "rumah" => $rumah
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.rumah_pengguna.create',[
            "nama" => User::where('user_status', 'pengguna')->get(),
            "cluster" => Cluster::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $renovasi = new Rumah();
        $renovasi-> user_id = $request-> user_id;
        $renovasi-> no_rumah = $request-> no_rumah;
        $renovasi->save();
        Alert::success('Data berhasil disimpan');
        return redirect('/rumah-pengguna');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.rumah_pengguna.edit',[
            "nama" => User::where('user_status', 'pengguna')->get(),
            "cluster" => Cluster::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $ipkl = Rumah::find($id);
        $ipkl->delete();
        return redirect('/rumah-pengguna');
    }

    public function getIPKLid($id)
    {
        $listing = Listing::where('cluster_id', $id)->get();
        $html   = '';
        foreach($listing as $data){
            // dd($data);
            $html .= '<option value="'.$data['id'].'">'.$data['no_rumah'].'</option>';
            // dd($html);
        }

        echo $html;
        // return response()->json($Listing);
    }

 
}
