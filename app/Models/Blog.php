<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $fillable = ['judul', 'desc', 'gambar'];

    public function blog_image(){
        return $this->hasOne(blog_image::class, 'blog_id', 'id');
    }

    public function getImageUrlAttribute($value)
    {
        return url('/').'/storage/'.$this->gambar;
    }
}
