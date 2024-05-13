<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Admin extends Model
{
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
}