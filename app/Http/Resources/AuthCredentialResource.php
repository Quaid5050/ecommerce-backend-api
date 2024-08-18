<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthCredentialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'email' => $this->email,
        ];
    }

}
