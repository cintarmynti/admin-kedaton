<?php

namespace App\Http\Controllers;

use App\Exports\PanicButtonExport;
use App\Models\PanicButton;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPanicButtonController extends Controller
{
    public function index(Request $request){
        if ($request->start_date ||$request->end_date) {
            // dd($request->start_date);
            $start_date = Carbon::parse($request->start_date)->toDateTimeString();
            // dd($start_date);
            $end_date = Carbon::parse($request->end_date)->toDateTimeString();
            $panic = PanicButton::with('user', 'properti')->whereBetween('created_at',[$start_date,$end_date])->get();

            // dd($panic);
        } else {
            $panic = PanicButton::with('user', 'properti')->get();
            // dd($panic);
        }

        // $panic = PanicButton::with('user', 'properti')->get();
        // dd($panic);
        return view('pages.laporan panic button.index', ['panic' => $panic]);
    }

    public function export_excel()
	{
		return Excel::download(new PanicButtonExport, 'panic-button.xlsx');
	}

    public function status($id){
        $data = PanicButton::findOrFail($id);
        // dd($status_id);
        $status_sekarang = $data->status_keterangan;
        // dd($data->status_keterangan);
        if($status_sekarang == 'not checked'){
            PanicButton::where('id', $id)->update([
                'status_keterangan' => 'checked'
            ]);
        }

        return redirect('/panic-button');
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

    public function get_detail($id){
        $panic = PanicButton::findOrFail($id);
        return response()->json($panic);
    }
}
