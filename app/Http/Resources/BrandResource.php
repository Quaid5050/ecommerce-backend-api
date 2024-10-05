<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'categories' =>  $this->when(
                $this->relationLoaded('categories') && $this->categories->isNotEmpty(),
                CategoryResource::collection($this->categories)),
            'series' =>  $this->when(
                $this->relationLoaded('series') && $this->series->isNotEmpty(),
                CategoryResource::collection($this->series)),
        ];
    }
}
