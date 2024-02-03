<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DemandResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'status' => $this->status,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'teams' => TeamResource::collection($this->whenLoaded('teams')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
            'created_by' => $this->whenLoaded('user', function() {
                // return new UserResource($this->user); Retorna o user completo
                return $this->user['first_name'] . ' ' . $this->user['last_name'];
            })
        ];
    }
}
