<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Renovasi;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class RenovasiController extends Controller
{
    public function index(){
        $renovasi = Renovasi::all();
        return ResponseFormatter::success('Data Otoritas Renovasi berhasil diambil', $renovasi);
    }

    public function create(){
        $input = request()->all();

        $validator = Validator::make($input, [
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'catatan_renovasi' => 'required',
            'catatan_biasa' => 'required'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::failed('Gagal membuat otoritas renovasi baru!', 401, $validator->errors());
        }

        $user = Auth::user();
        // $input['user_id'] = $user->id;
        $input['user_id'] = 4;

        $data = Renovasi::create($input);

        return ResponseFormatter::success('Berhasil membuat renovasi baru!', $data);
    }

    public function show($id){
        $data = Renovasi::find($id);
        if (is_null($data)) {
            return ResponseFormatter::failed('Data tidak ditemukan', 401);
        }
            return ResponseFormatter::success('Data berhasil diambil', $data);

    }

    public function edit(){

    }
}
