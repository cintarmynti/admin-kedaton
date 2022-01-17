<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanicButton extends Model
{
    use HasFactory;
    protected $table = 'panic_button';
    protected $fillable = ['user_id', 'id_rumah'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function listing(){
        return $this->belongsTo(Listing::class,'id_rumah','id');
    }
}
