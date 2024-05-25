<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;
    protected $table = 'promocode';
    protected $guarded = [];

    public function orders()
    {
        return $this->hasOne(ShopOrders::class, 'ID');
    }
}
