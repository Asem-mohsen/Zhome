<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function deliveryProductEstimation()
    {
        return $this->belongsTo(DeliveryProductEstimation::class, 'delivery_product_estimation_id');
    }
}
