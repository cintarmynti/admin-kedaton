<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renovasi extends Model
{
    use HasFactory;
    protected $table = 'renovasi';
    protected $fillable = ['user_id', 'rumah_id', 'tanggal_mulai', 'tanggal_akhir', 'catatan_renovasi', 'catatan_biasa'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function nomer(){
        return $this->hasOne(Listing::class, 'id', 'rumah_id');
    }
}
