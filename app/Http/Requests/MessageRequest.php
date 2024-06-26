<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'message' => ['required', 'string'],
            'username' => ['required', 'string'],
            'message_type' => ['required', 'string'],
            'task_id' => ['required', 'int', 'exists:tasks,id'],
            // 'sent_by' => ['required', 'int', 'exists:users,id'],
        ];
    }
}
