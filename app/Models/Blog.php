<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $fillable = ['judul', 'desc', 'gambar'];

    public function banner_image(){
        return $this->hasOne(blog_image::class, 'blog_id', 'id');
    }
}
