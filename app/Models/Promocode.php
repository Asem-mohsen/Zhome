<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;
    
    protected $table = 'promocode';

    protected $guarded = [];

    protected $casts = [
        'EndsIn' => 'datetime',
    ];


    public function orders()
    {
        return $this->hasOne(ShopOrders::class, 'ID');
    }
}
