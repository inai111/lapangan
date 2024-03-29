<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user' ;
    protected $guard = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }
    public function menerima_pesan()
    {
        return $this->hasMany(Message::class,'to_id');
    }
    public function mengirim_pesan()
    {
        return $this->hasMany(Message::class,'from_id');
    }
    public function booklist()
    {
        return $this->hasMany(Booklists::class,'from_id');
    }
}
