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
            'name' => $this->name,
            'email' => $this->email,
            'score' => $this->score,
            'image' => $this->profile?->image,          // Profildan olingan ma'lumot
            'user_name' => $this->profile?->user_name,  // Profildan olingan ma'lumot
        ];
    }
}
