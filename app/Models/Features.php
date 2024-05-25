<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    use HasFactory;
<<<<<<< HEAD
    
=======
>>>>>>> c9ef07c3fb8a08fda4d41df79ae9832660976b03
    protected $table = 'features';
    protected $guarded = [];

    public function product()
    {
<<<<<<< HEAD
        return $this->belongsToMany(ProductFeatures::class, 'productfeature' ,'FeatureID' , 'ProductID' ,'ID', 'ID');
    }
}
=======
        return $this->belongsTo(Product::class, 'ProductID', 'ID');
    }
}
>>>>>>> c9ef07c3fb8a08fda4d41df79ae9832660976b03
