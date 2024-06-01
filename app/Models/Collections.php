<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collections extends Model
{
    use HasFactory;
    protected $table = 'collections';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'collectionproducts', 'CollectionID', 'ProductID', 'ID' , 'ID');
    }

    public function features()
    {
        return $this->hasMany(CollectionFeatures::class, 'CollectionID', 'ID');
    }
}
