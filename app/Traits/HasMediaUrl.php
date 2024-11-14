<?php

namespace App\Traits;

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
