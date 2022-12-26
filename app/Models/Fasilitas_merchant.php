<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas_merchant extends Model
{
    use HasFactory;
    protected $table = 'fasilitas_merchant';
    public $timestamps = false;

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class,'fasilitas_id');
    }
}
