<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rev_listing extends Model
{
    use HasFactory;
    protected $table = 'rev_listing';
    protected $fillable = ['diskon', 'status', 'properti_id', 'harga', 'name', 'image', 'setelah_diskon', 'cluster_id', 'desc'];

     public function properti(){
        return $this->hasOne(Properti::class, 'id', 'properti_id');
    }

    public function cluster(){
        return $this->hasOne(Cluster::class, 'id', 'cluster_id');
    }

    public function getImageUrlAttribute($value)
    {
        return url('/').'/storage/'.$this->image;
    }
}
