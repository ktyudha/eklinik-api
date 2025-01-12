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
            'name' => 'required|string|unique:classifications,name,' . $this->route('id'),
            'price' => 'required|string',
            'description' => 'required',
            'menu' => 'required|array',
            'menu.*' => 'required|exists:menus,id'
        ];
    }
}
