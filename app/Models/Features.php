<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    use HasFactory;
    
    protected $table = 'features';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsToMany(ProductFeatures::class, 'productfeature' ,'FeatureID' , 'ProductID' ,'ID', 'ID');
    }
}
