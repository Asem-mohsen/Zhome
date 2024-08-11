<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HandleImgPath
{
    /**
     * Transform image paths for a model or collection.
     *
     * @param Model|Collection $data
     * @param array $imageFields
     * @param string $basePath
     * @return Model|Collection
     */

    public function transformImagePaths($data, array $imageConfig)
    {
        $transform = function ($item) use ($imageConfig) {
            foreach ($imageConfig as $field => $config) {
                if (isset($item->$field) && $item->$field) {
                    $basePath = $config['path'] ?? '';
                    $prefix = $config['prefix'] ?? '';
                    $suffix = $config['suffix'] ?? '';
                    $item->$field = asset($basePath . $prefix . $item->$field . $suffix);
                }
            }
            return $item;
        };

        if ($data instanceof Model) {
            return $transform($data);
        }

        return $data->transform($transform);
    }
}