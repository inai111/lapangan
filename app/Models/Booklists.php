<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booklists extends Model
{
    use HasFactory;

    public function lapangan()
    {
        return $this->hasOne(Lapangan::class,"id","lapangan_id");
    }
}
