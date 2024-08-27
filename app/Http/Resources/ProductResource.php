<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'printerModels'=> PrinterModelResource::collection($this->whenLoaded('printerModels')),
        ];
    }
}
