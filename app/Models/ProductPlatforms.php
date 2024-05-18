<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPlatforms extends Model
{
    use HasFactory;
    protected $table = 'productplatform';
    protected $guarded = [];

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class,'productplatform', 'PlatformID', 'ProductID');
    // }
}
