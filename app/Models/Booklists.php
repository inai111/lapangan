<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booklists extends Model
{
    use HasFactory;

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class,"lapangan_id");
    }
    public function transaction()
    {
        return $this->hasMany(Transactions::class,'booklists_id','id');
    }
    public function booking_date()
    {
        return $this->hasMany(Booking_date::class,'booklists_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
