<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInstallation extends Model
{
    use HasFactory;

    protected $table = 'order_installtions';

    protected $fillable = ['order_id' , 'installation_cost' , 'created_at' , 'updated_at'];
}
