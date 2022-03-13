<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'notifikasi';
    protected $fillable = ['user_id', 'sisi_status', 'heading', 'desc'];

    protected $appends = ['jam_hari'];

    public function getJamHariAttribute()
    {
        $jam = Carbon::parse($this->created_at)->format('h:i');
        return $jam;
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');

    }
}
