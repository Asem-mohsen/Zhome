<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteMarket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(SiteSetting::class, 'site_id');
    }
}
