<?php

namespace App\Http\Controllers;

use App\Models\Renovasi;
use Illuminate\Http\Request;

class RenovasiController extends Controller
{
    public function index(){
        $renovasi = Renovasi::with('user')->get();
        // dd($renovasi);
        return view('pages.otoritas renovasi.index', ['renovasi' => $renovasi]);
    }

    public function create(){

    }

    public function edit(){

    }

    public function update(){

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
