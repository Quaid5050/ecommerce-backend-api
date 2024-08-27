<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Conditionally include printerModels if they are loaded
            'printer_models' => PrinterModelResource::collection($this->whenLoaded('printerModels')),
        ];
    }
}
