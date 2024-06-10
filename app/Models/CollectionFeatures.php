<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionFeatures extends Model
{
    use HasFactory;
    protected $table = 'collectionfeatures';
    protected $guarded = [];

    public function collections()
    {
        return $this->hasMany(Collections::class, 'CollectionID', 'ID');
    }
}
