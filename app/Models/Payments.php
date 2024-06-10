<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $guarded = [];

    public function orders()
    {
        return $this->belongsTo(ShopOrders::class, 'TransactionID' , 'ID');
    }

    // public function users()
    // {
    //     return $this->belongsTo(User::class, 'TransactionID' , 'ID');
    // }
}
