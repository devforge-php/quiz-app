<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileReosurce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->user,
            'last_name' => $this->profile?->last_name,
            'image' => $this->profile?->image,        
            'score' => $this->score,
            'email' => $this->email,
          
        ];
    }
}
