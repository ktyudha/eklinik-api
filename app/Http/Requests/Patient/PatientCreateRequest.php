<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientCreateRequest extends FormRequest
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
            'medical_record_number' => 'required',
            'name' => 'required|string',
            'username' => 'required|string',
            'nik' => 'required|string',
            'email' => 'required|email|unique:patients,email',
            'phone_number' => 'required|string',
            'religion' => 'required|string',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'marital_status' => 'required|string',
            'education' => 'required|string',
            'job' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'sub_district_id' => 'required|exists:sub_districts,id',
            'village' => 'required|string',
        ];
    }
}
