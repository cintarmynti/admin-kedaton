<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rev_listing extends Model
{
    use HasFactory;
    protected $table = 'rev_listing';
    protected $fillable = ['diskon', 'status', 'properti_id', 'harga', 'name', 'image', 'setelah_diskon'];
}
