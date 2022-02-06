<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'notifikasi';
    protected $fillable = ['user_id', 'pembayaran_id', 'tanggal', 'desc', 'type'];
}
