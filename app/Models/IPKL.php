<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPKL extends Model
{
    use HasFactory;
    protected $table = 'pembayaran_ipkl';
    protected $fillable = ['user_id', 'tagihan_id', 'periode_pembayaran', 'bank', 'nominal', 'status', 'bukti_tf', 'type'];

    // public function nomer(){
    //     return $this->hasOne(Listing::class, 'id', 'listing_id');
    // }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
