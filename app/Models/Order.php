<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id')->with('product.translations');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'orders_promotions')->withTimestamps()->withPivot('user_id');
    }

    public function orderInstallation(): HasOne
    {
        return $this->hasOne(OrderInstallation::class);
    }

    public function getTotalAttribute()
    {
        return $this->products->sum(function ($product) {
            return $product->subtotal;
        });
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }
}
