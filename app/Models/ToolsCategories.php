<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsCategories extends Model
{
    use HasFactory;

    protected $table = 'toolscategoriesorders';
    protected $guarded = [];

    public function tools()
    {
        return $this->belongsTo(ToolsOrders::class, 'ToolOrderID', 'ID');
    }
}
