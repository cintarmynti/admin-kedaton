<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancel extends Model
{
    use HasFactory;
    protected $table = 'cancel';
    protected $fillable = ['alasan_dibatalkan', 'pemilik_mengajukan_id'];
}
