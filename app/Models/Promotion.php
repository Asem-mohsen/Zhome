<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orders_promotions')->withTimestamps()->withPivot('user_id');
    }
}
