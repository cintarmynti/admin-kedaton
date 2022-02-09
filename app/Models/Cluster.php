<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Model
{
    use HasFactory;
    protected $table = 'cluster';
    protected $fillable = ['name'];

    public function properti()
    {
        return $this->hasMany(Properti::class, 'cluster_id', 'id');
    }
}
