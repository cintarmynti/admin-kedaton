<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $table = 'listing';
    protected $fillable = [

        'no_rumah',
        'RT',
        'RW',
        'lantai',
        'jumlah_kamar',
        'luas_tanah',
        'luas_bangunan',
        'user_id_penghuni',
        'user_id_pemilik',
        'status',
        'tarif_ipkl',
        'harga'
    ];

    public function user_penghuni(){
        return $this->belongsTo(User::class, 'user_id_penghuni', 'id');

    }

    public function user_pemilik(){
        return $this->belongsTo(User::class, 'user_id_pemilik', 'id');

    }

    public function panic()
    {
        return $this->hasMany(PanicButton::class, 'id_rumah', 'id');
    }
}
