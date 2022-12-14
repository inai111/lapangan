<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_olahraga extends Model
{
    use HasFactory;
    protected $table = 'jenis_olahraga';

    public function lapangan()
    {
        return $this->hasMany(Lapangan::class);
    }
}
