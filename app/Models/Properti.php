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
    'harga'
 ];


}
