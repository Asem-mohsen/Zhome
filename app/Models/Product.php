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
        return $this->belongsToMany(Platform::class,'productplatform' ,'ProductID', 'PlatformID' ,'ID', 'ID');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'SubCategoryID', 'ID');
    }

    public function productDetails()
    {
        return $this->hasOne(ProductDetails::class, 'ProductID','ID');
    }

    public function technologies()
    {
        return $this->hasMany(ProductTechnology::class, 'ProductID', 'ID');
    }

    public function features()
    {
<<<<<<< HEAD
        return $this->belongsToMany(Features::class, 'productfeature' ,'ProductID' , 'FeatureID','ID', 'ID');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class,'collectionproducts' ,'ProductID', 'CollectionID','ID', 'ID');
=======
        return $this->hasMany(Features::class, 'ProductID' , 'ID');
    }
    public function productfeatures()
    {
        return $this->belongsToMany(Features::class, 'productfeature' ,'ProductID' , 'FeatureID');
>>>>>>> c9ef07c3fb8a08fda4d41df79ae9832660976b03
    }
    public function faqs()
    {
        return $this->hasMany(ProductFAQ::class, 'ProductID', 'ID');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'ProductID', 'ID');
    }

<<<<<<< HEAD
    public function sale()
    {
        return $this->hasOne(Sale::class, 'ProductID', 'ID');
    }

    public function evaluations(){
        return $this->hasOne(ProductEvaluation::class, 'ProductID' , 'ID');
    }

    public function orders(){
        return $this->hasMany(ShopOrders::class, 'ProductID' ,'ID');
    }
}
=======
    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->platforms()->delete();
            $product->faqs()->delete();
            $product->images()->delete();
            $product->technologies()->delete();
            $product->productfeatures()->delete();
        });
    }

    
}
>>>>>>> c9ef07c3fb8a08fda4d41df79ae9832660976b03
