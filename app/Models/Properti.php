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

    public function getCoverUrlAttribute()
    {
        $properti = Properti_image::where('properti_id', $this->id)->first();
        return $properti  == null ? '' : $properti->image ;
    }

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
