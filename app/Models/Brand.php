<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasMediaUrl;

class Brand extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasMediaUrl;

    protected $guarded = ['id'];

    protected $appends = ['image_url'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('brand-image');
    }

}
