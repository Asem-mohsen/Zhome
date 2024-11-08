<?php
namespace App\Traits;

use Illuminate\Support\Collection;

trait HasMediaUrl
{
    public function addMediaUrls($models, $collectionName = null)
    {
        return $models->map(function ($model) use ($collectionName) {
            $model->image_url = $model->getFirstMediaUrl($collectionName);
            return $model;
        });
    }
}
