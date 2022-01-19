<?php

namespace App\Http\Controllers;

use App\Models\Renovasi;
use App\Models\User;
use Illuminate\Http\Request;

class RenovasiController extends Controller
{
    public function index(){
        $renovasi = Renovasi::with('user')->get();
        // dd($renovasi);
        return view('pages.otoritas renovasi.index', ['renovasi' => $renovasi]);
    }

    public function create(){
        $user = User::all();
        return view('pages.otoritas renovasi.create', ['user' => $user]);
    }

    public function store(Request $request){
        $renovasi = new Renovasi();
        $renovasi-> user_id = $request-> user_id;
        $renovasi-> tanggal_mulai = $request-> tanggal_mulai;
        $renovasi-> tanggal_akhir = $request-> tanggal_akhir;
        $renovasi-> catatan_renovasi = $request-> catatan_renovasi;
        $renovasi-> catatan_biasa = $request->catatan_biasa;

        $renovasi->save();

        if ($renovasi) {
            return redirect()
                ->route('renovasi')
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
        $user = User::all();
        $renovasi = Renovasi::findOrFail($id);
        return view('pages.otoritas renovasi.edit', ['renovasi' => $renovasi, 'user'=> $user]);
    }

    public function update(Request $request, $id){
        $renovasi = Renovasi::findOrFail($id);
        $renovasi-> user_id = $request-> user_id;
        $renovasi-> tanggal_mulai = $request-> tanggal_mulai;
        $renovasi-> tanggal_akhir = $request-> tanggal_akhir;
        $renovasi-> catatan_renovasi = $request-> catatan_renovasi;
        $renovasi-> catatan_biasa = $request->catatan_biasa;

        $renovasi->update();

        if ($renovasi) {
            return redirect()
                ->route('renovasi')
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
        $post = Renovasi::findOrFail($id);
        $post->delete();

        if ($post) {
            return redirect()
                ->route('renovasi')
                ->with([
                    'success' => 'Post has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('renovasi')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
