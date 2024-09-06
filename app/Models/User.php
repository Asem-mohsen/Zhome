<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens , HasFactory, Notifiable;

    protected $table = 'user';
    protected $fillable = [
        'google_id',
        'session_id',
        'Name',
        'email',
        'password',
        'Status',
        'remember_token',
        'email_verified_at',
        'verification_code',
        'Address',
        'Phone',
        'DeletedOn',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(ShopOrders::class,'UserID', 'ID');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders', 'UserID' , 'ID');
    }

}
