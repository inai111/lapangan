<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;
    protected $table = 'merchants';
    protected $guard = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function lapangan()
    {
        return $this->hasMany(Lapangan::class);
    }
    public function history_balance()
    {
        return $this->hasMany(History_Balance::class);
    }
    public function fasilitas_merchant()
    {
        return $this->hasMany(Fasilitas_merchant::class);
    }
}
