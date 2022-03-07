<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;
    protected $table = 'complain';
    protected $fillable = ['user_id','pesan', 'complain'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
