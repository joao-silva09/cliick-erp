<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'services' => ServiceResource::collection($this->whenLoaded('services'))
        ];
    }
}
