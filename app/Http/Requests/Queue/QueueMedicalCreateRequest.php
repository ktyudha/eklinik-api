<?php

namespace App\Http\Requests\Queue;

use Illuminate\Foundation\Http\FormRequest;

class QueueMedicalCreateRequest extends FormRequest
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
            // 'queue_date' => 'required|date',
            'description' => 'required|string',
        ];
    }
}
