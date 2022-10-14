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
        return $this->hasOne(User::class);
    }
}
