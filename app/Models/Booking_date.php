<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking_date extends Model
{
    use HasFactory;
    protected $table = 'booking_date';

    public function booklist()
    {
        return $this->belongsTo(Booklists::class,'booklists_id');
    } 
}
