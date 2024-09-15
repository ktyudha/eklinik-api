<?php

namespace App\Http\Requests\Classification;

use Illuminate\Foundation\Http\FormRequest;

class ClassificationUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'menu_id' => 'required',
            'price' => 'required|string',
            'description' => 'required',
        ];
    }
}
