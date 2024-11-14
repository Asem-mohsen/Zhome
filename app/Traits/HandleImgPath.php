<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

trait HandleImgPath
{
    protected function getImageConfig($modelName)
    {
        return Config::get("image_paths.$modelName", []);
    }

    public function transformImagePaths($data)
    {
        $transform = function ($item) {
            if ($item instanceof Model) {
                $modelName = class_basename($item);
                $imageConfig = Config::get("image_paths.$modelName", []);

                foreach ($imageConfig as $field => $config) {
                    if (isset($item->$field) && $item->$field) {
                        $path = $config['path'] ?? '';
                        // Check if the path has already been transformed
                        if (strpos($item->$field, $path) === false) {
                            $item->$field = asset($path.$item->$field);
                        }
                    }
                }

                // Transform nested relationships
                foreach ($item->getRelations() as $relationName => $relationData) {
                    if ($relationName === 'images') {
                        $item->setRelation($relationName, $this->transformImagePaths($relationData));
                    } elseif ($relationName === 'features') {
                        $item->setRelation($relationName, $this->transformImagePaths($relationData));
                    } elseif ($relationName === 'productDetails') {
                        $item->setRelation($relationName, $this->transformImagePaths($relationData));
                    } else {
                        $item->setRelation($relationName, $this->transformImagePaths($relationData));
                    }
                }
            } elseif (is_array($item)) {
                // Handle array items (like images)
                foreach ($item as $key => $value) {
                    if (is_string($value) && strpos($key, 'Image') !== false) {
                        $path = Config::get('image_paths.images.Image.path', '');
                        if (strpos($value, $path) === false) {
                            $item[$key] = asset($path.$value);
                        }
                    }
                }
            }

            return $item;
        };

        if ($data instanceof Model) {
            return $transform($data);
        }

        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $data->setCollection($data->getCollection()->map($transform));

            return $data;
        }

        if (is_iterable($data)) {
            return collect($data)->map($transform);
        }

        return $data;
    }

    public function transformProductImagePaths(Product $product)
    {
        // Transform Product's own image
        if (isset($product->MainImage)) {
            $product->MainImage = asset('Admin/dist/img/web/Products/MainImage/'.$product->MainImage);
        }

        // Transform images relationship
        if ($product->images) {
            $product->images->transform(function ($image) {
                $image->Image = asset('Admin/dist/img/web/Products/OtherImages/'.$image->Image);

                return $image;
            });
        }

        // Transform features relationship
        if ($product->features) {
            $product->features->transform(function ($feature) {
                if (isset($feature->Image)) {
                    $feature->Image = asset('Admin/dist/img/web/Features/'.$feature->Image);
                }

                return $feature;
            });
        }

        // Transform productDetails relationship
        if ($product->productDetails && isset($product->productDetails->CoverImage)) {
            $product->productDetails->CoverImage = asset('Admin/dist/img/web/Products/CoverImage/'.$product->productDetails->CoverImage);
        }

        // Use the general transformImagePaths for other relationships
        if ($product->brand) {
            $product->brand = $this->transformImagePaths($product->brand);
        }
        if ($product->platforms) {
            $product->platforms = $this->transformImagePaths($product->platforms);
        }
        if ($product->subcategory) {
            $product->subcategory = $this->transformImagePaths($product->subcategory);
            if ($product->subcategory->category) {
                $product->subcategory->category = $this->transformImagePaths($product->subcategory->category);
            }
        }

        return $product;
    }
}
