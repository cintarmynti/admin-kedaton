<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listing_image extends Model
{
    use HasFactory;
    protected $table = 'listing_image';
    protected $fillable = ['image', 'listing_id'];

    public function setFilenamesAttribute($value)
    {
        $this ->attributes['image'] = json_encode($value);
    }
}
