<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $guarded = [];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'BrandID', 'ID');
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class,'productplatform' ,'ProductID', 'PlatformID');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'SubCategoryID', 'ID');
    }

    public function productDetails()
    {
        return $this->belongsTo(ProductDetails::class, 'ProductID', 'ID');
    }

    public function technologies()
    {
        return $this->hasMany(ProductTechnology::class, 'ProductID', 'ID');
    }

    public function features()
    {
        return $this->hasMany(ProductFeatures::class, 'ProductID' , 'ID');
    }

    public function faqs()
    {
        return $this->hasMany(ProductFAQ::class, 'ProductID', 'ID');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'ProductID', 'ID');
    }
}
