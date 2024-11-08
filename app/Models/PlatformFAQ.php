<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformFAQ extends Model
{
    use HasFactory;

    protected $table ='platforms_faq';

    protected $guarded = ['id'];

    public function platfroms(){

        return $this->belongsTo(Platform::class);
        
    }
}