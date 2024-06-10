<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    use HasFactory;
    protected $table   = 'productdetails';
    protected $guarded = [];

    public function productsDetails()
    {
        return $this->belongsTo(Product::class ,'ProductID' ,'ID');
    }
}
