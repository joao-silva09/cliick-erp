<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'created_at' => $this->created_at->format('d/m/Y'),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'team' => new TeamResource($this->team),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'messages' => MessageResource::collection($this->whenLoaded('messages')),
            'created_by' => ($this->whenLoaded('user', function() {
                // return new UserResource($this->user); Retorna user completo
                return $this->user['first_name'] . ' ' . $this->user['last_name'];
            })),
        ];
    }
}
