<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'between:2,200'],
            'description' => ['string'],
            'deadline' => ['date'],
            'status' => ['required', 'string'],
            'demand_id' => ['required', 'int', 'exists:demands,id'],
            'users_ids' => ['required', 'array', 'exists:users,id'],
            'created_by' => ['required', 'int', 'exists:users,id'],
        ];
    }
}
