<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image_url' => $this->getFirstMediaUrl('product_featured_image'),
            'price' => $this->price,
            'is_on_sale' => $this->is_on_sale ? 1 : 0,
            'sale_price' => $this->sale_price ? $this->sale_price : 0,
            'brand' => [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
                'brand_image' => $this->brand->getFirstMediaUrl('brand-image'),
            ],
            'translations' => [
                'locale' => $this->translations->locale,
                'name' => $this->translations->name,
            ],
            'platforms' => $this->platforms->map(function ($platform) {
                return [
                    'id' => $platform->id,
                    'name' => $platform->name,
                    'image_url' => $platform->getFirstMediaUrl('platform-image'),
                ];
            }),
        ];
    }
}
