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
        return $this->belongsTo(Merchant::class);
    }
    public function galleries()
    {
        return $this->hasMany(Gallery::class,'lapangan_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class,'lapangan_id');
    }
    public function booklist()
    {
        return $this->hasMany(Booklists::class);
    }
    public function jenis()
    {
        return $this->belongsTo(Jenis_olahraga::class,'jenis_olahraga_id');
    }
}
