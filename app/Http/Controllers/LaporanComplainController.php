<?php

namespace App\Http\Controllers;

use App\Models\Complain;
use Illuminate\Http\Request;

class LaporanComplainController extends Controller
{
    public function index(){
        $complain = Complain::with('user')->get();
        // dd($complain);
        return view('pages.laporan complain.index', ['complain' => $complain]);
    }

    public function create(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function delete($id){
        $post = Complain::findOrFail($id);
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
}
