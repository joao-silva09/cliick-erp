<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'entry_date' => $this->entry_date,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'demands' => DemandResource::collection($this->whenLoaded('demands')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
