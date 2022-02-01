<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPKL extends Model
{
    use HasFactory;
    protected $table = 'pembayaran_ipkl';
    protected $fillable = ['rumah_id', 'periode_pembayaran', 'metode_pembayaran', 'jumlah_pembayaran', 'status'];

    public function nomer(){
        return $this->hasOne(Listing::class, 'id', 'rumah_id');
    }
}
