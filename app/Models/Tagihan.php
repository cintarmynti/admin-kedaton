<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\type;

class Tagihan extends Model
{
    use HasFactory;


    protected $table = 'tagihan';
    protected $fillable = [
        'cluster_id',
        'properti_id',
        'periode_pembayaran',
        'jumlah_pembayaran'
    ];

    protected $appends = ['bulan_thn', 'tanggal'];

    public function getBulanThnAttribute(){
        $waktu = Carbon::parse($this->created_at)->format('F Y');
        return $waktu;
    }

    public function getTanggalAttribute(){
        $tanggal =  Carbon::parse($this->created_at)->format('D/m/Y');
        return $tanggal;
    }

    public function ipkl(){
        return $this->hasMany(IPKL::class, 'tagihan_id', 'id');
    }

     public function nomer(){
        return $this->hasOne(Properti::class, 'id', 'properti_id');
    }

    public function cluster(){
        return $this->hasOne(Cluster::class, 'id', 'cluster_id');
    }


    // public function properti(){
    //     return $this->hasOne(Properti::class, 'id', 'user_id');
    // }

    public function type(){
        return $this->hasOne(type_pembayaran::class, 'id', 'type_id');
    }



}
