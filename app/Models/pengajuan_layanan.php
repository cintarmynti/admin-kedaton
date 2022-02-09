<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengajuan_layanan extends Model
{
    use HasFactory;
    protected $table =  'pengajuan_layanan';
    protected $fillable = ['layanan_id', 'user_id', 'tanggal', 'status', 'jam', 'catatan'];
}
