<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properti extends Model
{
    use HasFactory;
    protected $table = 'properti';
    protected $fillable = [
        'pemilik_id',
        'cluster_id',
        'no_rumah',
        'no_listrik',
        'no_pam_bsd',
        'penghuni_id',
        'alamat',
        'RT',
        'RW',
        'lantai',
        'jumlah_kamar',
        'luas_tanah',
        'luas_bangunan',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'tarif_ipkl',
        'status',
        // 'harga',
        'kamar_mandi',
        'status_pengajuan_penghuni',
        'carport',
        'gambar'
    ];

    protected $appends = ['telp'];

    public function getCoverUrlAttribute()
    {
        $properti = Properti_image::where('properti_id', $this->id)->first();
        return $properti  == null ? '' : $properti->image ;
    }

    public function getTelpAttribute()
    {
        $user = User::where('id', $this->pemilik_id)->first();
        if($user != null){
            $user->phone = (int)$user->phone;
            return $user->phone;
        }

    }

    // public function getStatusPenghuniAttribute($value)
    // {
    //     $penghuni = Pengajuan::where('pemilik_mengajukan', $this->pemilik_id)->where('properti_id_penghuni', $this->id)->first();
    //     // dd($penghuni);
    //     if($penghuni == null){
    //         return '';
    //     }

    //     if($penghuni->status_verivikasi == 1){
    //         return 'terverifikasi';
    //     }else{
    //         return 'menunggu verifikasi';
    //     }
    // }

    public function penghuni()
    {
        return $this->hasOne(User::class, 'id', 'penghuni_id');
    }

    public function cluster()
    {
        return $this->hasOne(Cluster::class, 'id', 'cluster_id');
    }

    public function pemilik()
    {
        return $this->hasOne(User::class, 'id', 'pemilik_id');
    }



}
