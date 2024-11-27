<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryProductEstimation extends Model
{
    use HasFactory;

    protected $fillable = ['estimation_details', 'estimated_delivery_date' ,'country_id' , 'city_id'];

    protected $casts = ['estimated_delivery_date' => 'date'];

    protected $table = 'delivery_product_estimations';

    public function deliveryProduct()
    {
        return $this->belongsTo(DeliveryProduct::class, 'delivery_product_estimation_id');
    }

    public function products()
    {
        return $this->hasMany(DeliveryProduct::class, 'delivery_product_estimation_id')->with('product');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
