<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'video_url' => $this->video_url,
            'description' => $this->description,
            'ar_description' => $this->ar_description,
            'image_url' => $this->getFirstMediaUrl('platform-image'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'products' => ProductCardResource::collection($this->whenLoaded('products')),

            // Include FAQs
            'faqs' => $this->whenLoaded('faqs', function () {
                return $this->faqs->map(function ($faq) {
                    return [
                        'id' => $faq->id,
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                        'created_at' => $faq->created_at,
                        'updated_at' => $faq->updated_at,
                    ];
                });
            }),

        ];
    }
}
