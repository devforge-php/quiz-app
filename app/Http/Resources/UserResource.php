<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'user_name' => $this->user_name,
            'name' => $this->profile?->name,
            'last_name' => $this->profile?->last_name,
            'image' => $this->profile?->image,        
            'score' => $this->score,
            'email' => $this->email,
        ];
    }
}
