<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $table = 'product_translations';

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
