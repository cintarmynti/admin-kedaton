<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';
    protected $fillable = ['user_id', 'properti_id', 'properti_id_penghuni', 'pemilik_mengajukan'];


    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function user_pemilik(){
        return $this->hasOne(User::class,'id', 'pemilik_mengajukan');
    }
}
