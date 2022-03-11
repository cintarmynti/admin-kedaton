<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $appends = ['image_url', 'tanggal_dibayarkan'];

    public function getImageUrlAttribute($value)
    {
        return url('/').'/storage/'.$this->bukti_tf;
    }

    public function tagihan(){
        return $this->hasOne(Tagihan::class, 'id', 'tagihan_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getTanggalDibayarkanAttribute(){
        $tanggal =  Carbon::parse($this->created_at)->format('d F | h:i');
        return $tanggal;
    }

    public function type(){
        return $this->hasOne(type_pembayaran::class, 'id', 'type');
    }
}
