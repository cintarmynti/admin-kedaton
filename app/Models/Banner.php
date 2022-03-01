<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Banner extends Model
{
    use HasFactory;
    protected $table = 'banner';
    protected $fillable = ['foto', 'link', 'judul'];

    public function getImageUrlAttribute($value)
    {
        return url('/').'/storage/'.$this->foto;
    }
}



