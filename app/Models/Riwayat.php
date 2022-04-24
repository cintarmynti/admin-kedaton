<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Riwayat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'riwayat_pembayaran';
    protected $fillable = ['user_id', 'type_pembayaran', 'harga', 'created_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function type(){
        return $this->hasOne(type_pembayaran::class, 'id', 'type_pembayaran');
    }

    public function getCreatedAtAttribute($value)
    {
        $tanggal =  Carbon::parse($value)->format('Y-m-d');
        return $tanggal;
    }
}
