<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $guarded = ['id'];

    protected $appends = ['image_url'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'product_platforms', 'product_id', 'platform_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function translations()
    {
        return $this->hasOne(ProductTranslation::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function dimensions()
    {
        return $this->hasMany(ProductDimension::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'product_technologies', 'product_id', 'technology_id');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'product_feature', 'product_id', 'feature_id');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'product_collection', 'product_id', 'collection_id');
    }

    public function faqs()
    {
        return $this->hasMany(ProductFaq::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'orders', 'user_id');
    }

    public function deliveryEstimations()
    {
        return $this->hasManyThrough(DeliveryProductEstimation::class,DeliveryProduct::class,'product_id', 'id', 'id', 'delivery_product_estimation_id' );
    }
    
    public function isOnSale()
    {
        return $this->sale && $this->sale->sale_price < $this->price;
    }

    public function getCurrentPrice()
    {
        return $this->isOnSale() ? $this->sale->sale_price : $this->price;
    }

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('product_featured_image');
    }

    public function getOtherImagesAttribute()
    {
        return $this->getMedia('product_other_image')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'name' => $media->name,
                'created_at' => $media->created_at,
                'updated_at' => $media->updated_at,
            ];
        });
    }
}
