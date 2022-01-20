<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blog_image extends Model
{
    use HasFactory;
    protected $table = 'blog_image';
    protected $fillable = ['image', 'blog_id'];
}
