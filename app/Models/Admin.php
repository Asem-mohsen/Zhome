<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    protected $table = 'admin';

    protected $fillable = [
        'Name',
        'DOB',
        'Phone',
        'Email',
        'Password',
        'Address',
        'RoleID'
    ];

    protected $casts = [
        'Password' => 'hashed',
    ];
}
