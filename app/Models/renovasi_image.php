<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class renovasi_image extends Model
{
    use HasFactory;
    protected $table = 'renovasi_image';
    protected $fillable = ['image', 'renovasi_id'];
}
