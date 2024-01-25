<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemandRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['string'],
            'deadline' => ['date'],
            'status' => ['required', 'string'],
            'customer_id' => ['required', 'int', 'exists:customers,id'],
            'teams_ids' => ['required', 'array', 'exists:teams,id'],
            'created_by' => ['required', 'id', 'exists:users,id'],
        ];
    }
}
