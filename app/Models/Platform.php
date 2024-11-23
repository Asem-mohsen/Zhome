<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Platform extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $guarded = ['id'];

    protected $appends = ['image_url'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_platforms', 'platform_id', 'product_id');
    }

    public function faqs()
    {
        return $this->hasMany(PlatformFAQ::class);
    }

    public function toolOrders()
    {
        return $this->belongsToMany(ToolOrder::class, 'tool_platforms', 'platform_id', 'tool_order_id');
    }
    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('platform-image');
    }
}
