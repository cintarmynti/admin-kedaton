<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penghuniDetail extends Model
{
    use HasFactory;
    protected $table = 'penghuni_detail';
    protected $fillable = ['penghuni_id', 'properti_id'];

    public function penghuni()
    {
        return $this->hasOne(User::class, 'id', 'penghuni_id');
    }
}
