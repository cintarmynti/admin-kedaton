<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'nik',
        'alamat',
        'phone',
        'photo_identitas',
        'user_status',
        'password'

    ];

    public function properti(){
        return $this->hasOne(Properti::class, 'user_id', 'id');
    }

    public function pemilik()
    {
        return $this->hasMany(Listing::class, 'user_id_pemilik', 'id');
    }

    public function penghuni()
    {
        return $this->hasMany(Listing::class, 'user_id_penghuni', 'id');
    }

    public function complain(){
        return $this->hasOne(Complain::class, 'user_id', 'id');
    }

    public function renovasi(){
        return $this->hasOne(Renovasi::class, 'user_id', 'id');
    }

    public function panic()
    {
        return $this->hasMany(PanicButton::class, 'user_id', 'id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
