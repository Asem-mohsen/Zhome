<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTechnology extends Model
{
    use HasFactory;
    protected $table = 'producttechnology';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ID');
    }
}
