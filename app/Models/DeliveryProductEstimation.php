<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryProductEstimation extends Model
{
    use HasFactory;

    protected $fillable = ['estimation_details', 'estimated_delivery_date'];

    protected $casts = ['estimated_delivery_date' => 'date'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'delivery_product', 'delivery_product_estimation_id', 'product_id');
    }

}
