<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEvaluation extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $table = 'expertevaluation';
    protected $guarded = [];

    public function products(){

        return $this->belongsTo(Product::class, 'ProductID' ,'ID');

    }
}
=======

    protected $table = 'expertevaluation';
    protected $guarded = [];
}
>>>>>>> c9ef07c3fb8a08fda4d41df79ae9832660976b03
