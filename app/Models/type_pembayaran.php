<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_pembayaran extends Model
{
    use HasFactory;
    protected $table = 'type_pembayaran';
    protected $fillable = ['name'];

    public function tagihan()
    {
        $this->hasMany(Tagihan::class, 'type_id', 'id');
    }
}
