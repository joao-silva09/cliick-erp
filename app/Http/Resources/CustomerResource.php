<?php

namespace App\Http\Resources;

use App\Models\Company;
use Carbon\Carbon;
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
            'phone' => $this->phone,
            'entry_date' => Carbon::parse($this->entry_date)->format('d/m/Y'),
            'company' => new CompanyResource($this->whenLoaded('company')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
