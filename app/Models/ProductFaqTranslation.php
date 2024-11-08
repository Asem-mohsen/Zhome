<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFaqTranslation extends Model
{
    use HasFactory;

    protected $table = 'product_faq_translations';

    protected $guarded = ['id'];

    public function faq()
    {
        return $this->belongsTo(ProductFaq::class, 'faq_id');
    }
    
}
