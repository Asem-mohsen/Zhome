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
        'email',
        'password',
        'Address',
        'RoleID'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
    protected $hidden = ['password', 'remember_token'];

    public function roles(){
        
        return $this->belongsTo(Roles::class, 'RoleID','ID');
        
    }

    public function ProductEvaluation(){
        
        return $this->belongsTo(ProductEvaluation::class, 'ExpertID','id');
        
    }
}