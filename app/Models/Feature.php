<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasMediaUrl;

class Feature extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasMediaUrl;

    protected $guarded = ['id'];

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class , 'product_feature');
    }

    public function collections() : BelongsToMany
    {
        return $this->belongsToMany(Collection::class);
    }
}
