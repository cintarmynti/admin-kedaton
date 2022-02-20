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
        'tarif_ipkl',
        'status',
        'harga',
        'kamar_mandi',
        'carport'
    ];


    public function pemilik()
    {
        return $this->hasOne(User::class, 'id', 'pemilik_id');
    }

    public function penghuni()
    {
        return $this->hasOne(User::class, 'id', 'penghuni_id');
    }
    public function cluster()
    {
        return $this->hasOne(Cluster::class, 'id', 'cluster_id');
    }
}
