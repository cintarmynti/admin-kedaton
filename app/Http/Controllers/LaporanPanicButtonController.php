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

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $query = PanicButton::with('user', 'properti');
        // dd($start_date);

        if($request -> start_date){
            $query->whereBetween('created_at',[$start_date,$end_date]);
        }

        if($request -> status){
            $query -> where('status_keterangan', $request->status);
        }


        return view('pages.laporan panic button.index', ['panic' => $query->get()]);
    }

    public function dashboard_update($id)
    {
        $panic = PanicButton::where('id', $id)->update([
            'status_keterangan' => 'checked'
        ]);

        // if($panic){
        //     dd($panic);
        // }
        return redirect('/dashboard');

    }

    public function dashboard_all()
    {
        $panic_button = PanicButton::where('status_keterangan', 'not checked')->get();
        foreach($panic_button as $p){
            $p->update([
                'status_keterangan' => 'checked'
            ]);
        }

        return redirect('/dashboard');

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
		return Excel::download(new PanicButtonExport($from, $to, $status), 'panic-button.xlsx');
	}

    public function status($id, Request $request){
        $data = PanicButton::where('id', $request->id)->first();
        // dd($data)
        // dd($status_id);
        $data->user_id = $request->user_id;
        $data->id_rumah = $request->id_rumah;
        $data->status_keterangan = 'checked';
        $data->keterangan = $request->keterangan;
        $data->update();



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
