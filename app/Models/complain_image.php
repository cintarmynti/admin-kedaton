<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class complain_image extends Model
{
    use HasFactory;
    protected $table = 'complain_image';
    protected $fillable = ['image', 'complain_id'];
}
