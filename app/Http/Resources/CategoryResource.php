<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ar_name' => $this->ar_name,
            'description' => $this->description,
            'ar_description' => $this->ar_description,
            'additional_description' => $this->additional_description,
            'ar_additional_description' => $this->ar_additional_description,
            'image_url' => $this->getFirstMediaUrl('category-image'),
            'has_sub' => $this->has_sub,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Count subcategories
            'subcategories_count' => $this->subcategories()->count(),
            // Count products
            'products_count' => $this->products()->count(),

            'subcategories'=> SubcategoryResource::collection($this->whenLoaded('subcategories')),
            'products' => ProductCardResource::collection($this->whenLoaded('products')),
        ];
    }
}
