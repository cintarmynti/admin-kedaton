<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Riwayat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'riwayat_pembayaran';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
