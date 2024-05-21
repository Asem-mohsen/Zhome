<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEvaluation extends Model
{
    use HasFactory;

    protected $table = 'expertevaluation';
    protected $guarded = [];
}