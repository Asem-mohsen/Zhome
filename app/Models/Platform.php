<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    
    protected $table = 'platform';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'productplatform', 'PlatformID', 'ProductID','ID', 'ID');
    }

}