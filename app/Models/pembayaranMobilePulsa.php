<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaranMobilePulsa extends Model
{
    use HasFactory;
    protected $table = 'pembayaran_mobile_pulsas';

    protected $fillable = [
        'type',
       'tr_id',
        'user_id',
       'bank',
       'nominal',
       'no_pelanggan',
        'status',
        'bukti_tf'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getBuktiTfAttribute($value)
    {
        return url('/').'/storage/'.$value;
    }
}
