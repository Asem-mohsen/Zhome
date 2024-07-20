<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = [];

    public function transaction()
    {
        return $this->belongsTo(Payments::class, 'TransactionID' , 'ID');
    }

    public function promocode()
    {
        return $this->hasOne(Promocode::class, 'ID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID' , 'ID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'id');
    }

}
