<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properti_image extends Model
{
    use HasFactory;
    protected $table = 'properti_images';
    protected $guarded = ['id'];
    protected $fillable = ['id', 'image'];

    public function getImageUrlAttribute($value)
    {
        return url('/').'/storage/'.$this->image;
    }

}
