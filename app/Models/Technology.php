<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Technology extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $guarded = ['id'];

    protected $appends = ['image_url'];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_technolgies', 'technology_id' , 'product_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('technology-image');
    }
}
