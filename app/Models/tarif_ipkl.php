<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tarif_ipkl extends Model
{
    use HasFactory;
    protected $table = 'tarif_ipkl';
    protected $fillable = ['luas_kavling_awal', 'luas_kavling_akhir', 'tarif'];
}
