<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFaq extends Model
{
    use HasFactory;

    protected $table = 'productfaq';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID', 'ID');
    }
}
