<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;
    protected $table = 'complain';
    protected $fillable = ['user_id','nama', 'alamat', 'catatan','pesan', 'complain' ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    protected $appends = ['gambar', 'tanggal'];

    public function getTanggalAttribute(){
        $tanggal =  Carbon::parse($this->created_at)->format('d M Y');
        return $tanggal;
    }

    public  function getGambarAttribute()
    {
        $gambar = complain_image::where('complain_id', $this->id)->get();
        $myArr = [];

        foreach($gambar as $gbr){
            $img = url('/').'/storage/'. $gbr->image;
            array_push($myArr, $img);
        }
        return $myArr;

    }

}
