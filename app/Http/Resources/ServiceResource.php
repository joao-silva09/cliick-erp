<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'description' => $this->description,
            'base_value' => $this->base_value,
            'recurrence' => $this->recurrence,
            'active' => $this->active,
            'contracts' => ContractResource::collection($this->whenLoaded('services')),
        ];
    }
}
