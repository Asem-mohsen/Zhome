<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Platform;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Config;

trait HandleImgPath
{

    protected function getImageConfig($modelName)
    {
        return Config::get("image_paths.$modelName", []);
    }

    public function transformImagePaths($data, $customConfig = null)
    {
        $transform = function ($item) use ($customConfig) {
            if (!$item instanceof Model) {
                return $item;
            }

            $modelName = class_basename($item);
            $imageConfig = $customConfig ?? $this->getImageConfig($modelName);

            foreach ($imageConfig as $field => $config) {
                if (isset($item->$field) && $item->$field) {
                    $basePath = $config['path'] ?? '';
                    $prefix = $config['prefix'] ?? '';
                    $suffix = $config['suffix'] ?? '';
                    
                    // Check if the field already contains the full URL
                    if (!filter_var($item->$field, FILTER_VALIDATE_URL)) {
                        $item->$field = asset($basePath . $prefix . $item->$field . $suffix);
                    }
                }
            }

            // Transform nested relationships
            foreach ($item->getRelations() as $relationName => $relationData) {
                $item->setRelation($relationName, $this->transformImagePaths($relationData));
            }

            return $item;
        };

        if ($data instanceof Model) {
            return $transform($data);
        }

        if (is_iterable($data)) {
            return collect($data)->map($transform);
        }

        return $data;
    }
}