<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';
    protected $fillable = [
        'Brand',
        'Logo',
        'MainDescription',
        'OtherDescription',
        'MainArabic',
        'OtherArabicDescription',	
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'BrandID', 'ID');
    }
}