<?php

namespace App\Http\Requests\Medicine;

use Illuminate\Foundation\Http\FormRequest;

class RecipeCreateRequest extends FormRequest
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
            'patient_id' => 'required|string|exists:patients,id',
            'medical_id' => 'required|string|exists:medicals,id',
            'description' => 'nullable|string',
            'medicine' => 'required|array',
            'medicine.*.id' => 'required|exists:medicines,id',
            'medicine.*.quantity' => 'required|numeric|min:0'
        ];
    }
}
