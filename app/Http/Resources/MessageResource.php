<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'message' => $this->message,
            'username' => $this->username,
            'message_type' => $this->message_type,
            'created_at' => $this->created_at,
            'sent_by' => new UserResource($this->whenLoaded('user')),
            'task' => new TaskResource($this->whenLoaded('task'))
        ];
    }
}
