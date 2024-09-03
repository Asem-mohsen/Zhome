<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformFAQ extends Model
{
    use HasFactory;
    protected $table ='platformq&a';
    protected $guarded = [];

    public function platfroms(){
        return $this->belongsTo(Platform::class , 'PlatformID' , 'ID');
    }
}