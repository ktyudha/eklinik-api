<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class SubMenuCreateRequest extends FormRequest
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
            'menu_id' => 'required|string',
            'name' => 'required|string|unique:sub_menus',
            'type' => 'required|in:textrich,input,textarea,radio,combobox,checkboxm,date,time,datetime,select',
            'is_active' => 'required',
        ];
    }
}
