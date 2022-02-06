<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';
    protected $fillable = [
        'cluster_id',
        'listing_id',
        'periode_pembayaran',
        'jumlah_pembayaran'
    ];

     public function nomer(){
        return $this->hasOne(Listing::class, 'id', 'listing_id');
    }

    public function cluster(){
        return $this->hasOne(Cluster::class, 'id', 'cluster_id');
    }



}
