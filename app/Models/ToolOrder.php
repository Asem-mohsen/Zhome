<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ToolOrder extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $guarded = ['id'];

    protected $table = 'tool_orders';


    public function orders()
    {
        return $this->hasMany(Order::class,'user_id');
    }

    public function option()
    {
        return $this->hasOne(ToolOption::class,'tool_order_id');
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'tool_platforms', 'tool_order_id', 'platform_id');
    }

    public function toolCategories()
    {
        return $this->hasMany(ToolCategory::class, 'tool_order_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('house_documents');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
