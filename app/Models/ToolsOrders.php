<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsOrders extends Model
{
    use HasFactory;

    protected $table = 'toolorders';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }

    public function toolsCategories()
    {
        return $this->hasMany(ToolsCategories::class, 'ToolOrderID', 'ID');
    }

}
