<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEvaluation extends Model
{
    use HasFactory;
    protected $table = 'expertevaluation';
    protected $guarded = [];

    public function products(){

        return $this->belongsTo(Product::class, 'ProductID' ,'ID');

    }
}
