<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function pengirim()
    {
        return $this->belongsTo(User::class,'from_id');   
    }
    public function penerima()
    {
        return $this->belongsTo(User::class,'to_id');   
    }
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class,'to_id');   
    }
}
