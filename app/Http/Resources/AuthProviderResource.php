<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthProviderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'provider_name' => $this->provider_name,
            'email' => $this->when($this->email, $this->email),
        ];
    }
}
