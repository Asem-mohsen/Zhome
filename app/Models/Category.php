<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $guarded = [];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'MainCategoryID', 'ID');
    }

}
