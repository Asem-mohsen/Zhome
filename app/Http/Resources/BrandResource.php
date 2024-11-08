<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'ar_description' => $this->ar_description,
            'additional_description' => $this->additional_description,
            'ar_additional_description' => $this->ar_additional_description,
            'image_url' => $this->getFirstMediaUrl('brand-image'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'products' => ProductCardResource::collection($this->whenLoaded('products')),
        ];
    }
}
