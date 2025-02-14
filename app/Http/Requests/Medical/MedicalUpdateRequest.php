<?php

namespace App\Http\Requests\Medical;

use Illuminate\Foundation\Http\FormRequest;

class MedicalUpdateRequest extends FormRequest
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
            'patient_id' => 'required|string',
            'classification_id' => 'required|string',
            'checkup_date' => 'required|date',
            'submenu' => 'required|array',
            'submenu.*.id' => 'required|exists:sub_menus,id',
            'submenu.*.name' => 'required|string',
            'submenu.*.value' => 'required',
        ];
    }
}
