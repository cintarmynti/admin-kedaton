<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobile_pulsa extends Model
{
    use HasFactory;
    protected $table = 'mobile_pulsa';
    protected $fillable = [
        'user_id',
        'total',
        'status_pembayaran',
        'no_hp',
        'jenis_pembayaran'
    ];
}
