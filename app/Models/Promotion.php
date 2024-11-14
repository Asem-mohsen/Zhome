<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['valid_until' => 'date' , 'valid_from' => 'date'];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orders_promotions')->withTimestamps()->withPivot('user_id');
    }
}
