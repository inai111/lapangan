<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;
    protected $table = 'lapangan';

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }
    public function gallery()
    {
        return $this->hasMany(Gallery::class,'ref_id');
    }
}
