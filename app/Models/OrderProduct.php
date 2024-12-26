<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_product';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getSubtotalAttribute()
    {
        $product = $this->product;

        $currentPrice = $product->getCurrentPrice();

        $subtotal = $this->quantity * $currentPrice;

        if ($this->with_installation) {
            $subtotal += $product->installation_cost;
        }

        return $subtotal;
    }
}
