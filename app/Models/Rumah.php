<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'rumah_pengguna';

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function nomer_rumah(){
        return $this->hasOne(Properti ::class, 'id', 'no_rumah');
    }
}
