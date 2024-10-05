<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brands' => $this->when(
                $this->relationLoaded('brands') && $this->brands->isNotEmpty(),
                         BrandResource::collection($this->brands)),
        ];
    }
}
