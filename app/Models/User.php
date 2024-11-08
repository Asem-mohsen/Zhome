<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens , HasFactory, Notifiable;

    protected $table = 'users';

    protected $guarded = ['id'];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function orderItems() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'orders', 'user_id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(UserPhone::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(UserAddress::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'orders_promotions')->withTimestamps()->withPivot('order_id');
    }

}
