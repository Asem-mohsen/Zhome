<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sale';

    protected $fillable = [
        'ProductID','Amount' ,'EndDate','PriceAfter','StartDate'
    ];

    protected $dates = ['EndDate'];
    
    public function products(){

        return $this->belongsTo(Product::class, 'ProductID', 'ID');

    }
}