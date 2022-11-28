<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History_Balance extends Model
{
    use HasFactory;
    protected $table = 'history_balance';

    public function merchant()
    {
        return $this->hasOne(Merchant::class,'merchant_id','id');
    }
}
