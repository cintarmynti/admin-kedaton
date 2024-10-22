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
        'photo_ktp',
        'user_status',
        'password',
        'status_penghuni',
        'email_pengajuan',
        'snk',
        'fcm_token'

    ];

    public function getPhotoIdentitasAttribute($value)
    {
        return url('/').'/storage/'.$value;
    }

    public function getPhotoKtpAttribute($value)
    {
        return url('/').'/storage/'.$value;
    }

    public function getImageUrlAttribute($value)
    {
        return  url('/').'/storage/'.$this->photo_identitas;
    }

    public function getImageKtpAttribute($value)
    {
        return url('/').'/storage/'.$this->photo_ktp;
    }

    public function getEmailCekAttribute($value)
    {
        // $nik = $this->nik == null ? '' : $this->nik;
        return $this->email;
    }

    public function properti(){
        return $this->hasOne(Properti::class, 'pemilik_id', 'id');
    }

    public function properti_penghuni(){
        return $this->hasOne(Properti::class, 'penghuni_id', 'id');
    }

    public function pemilik()
    {
        return $this->hasMany(Properti::class, 'pemilik_id', 'id');
    }

    public function penghuni()
    {
        return $this->hasMany(Properti::class, 'penghuni_id', 'id');
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
