<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(SitePhone::class, 'site_id');
    }

    public function markets(): HasMany
    {
        return $this->hasMany(SiteMarket::class, 'site_id');
    }
}
