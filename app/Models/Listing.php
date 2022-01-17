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
        'harga'
    ];

    public function panic()
    {
        return $this->hasMany(PanicButton::class, 'id_rumah', 'id');
    }
}
