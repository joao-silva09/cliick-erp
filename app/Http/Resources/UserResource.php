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
        return [
            'id' => (integer)$this->id,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'email' => (string)$this->email,
            'phone' => (string)$this->phone,
            'user_type' => (string)$this->user_type,
            'profile_photo' => (string)$this->profile_photo,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'company' => new CompanyResource($this->whenLoaded('company'))
        ];
    }
}
