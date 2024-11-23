<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'tool_categories';

    public function toolOrder()
    {
        return $this->belongsTo(ToolOrder::class, 'tool_order_id', 'id');
    }
}
