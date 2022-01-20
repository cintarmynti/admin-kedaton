<?php

namespace App\Http\Controllers;

use App\Models\PanicButton;
use Illuminate\Http\Request;

class LaporanPanicButtonController extends Controller
{
    public function index(){
        $panic = PanicButton::with('user', 'listing')->get();
        // dd($panic);
        return view('pages.laporan panic button.index', ['panic' => $panic]);
    }

    public function create(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function delete($id){
        $post = PanicButton::findOrFail($id);
        $post->delete();

        if ($post) {
            return redirect()
                ->route('panic')
                ->with([
                    'success' => 'Post has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('panic')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
