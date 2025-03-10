<?php

namespace App\Http\Requests\Command;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommandRequest extends FormRequest
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
            'name'          =>  'nullable|string|max:255',
            'fullName'      =>  'nullable|string|max:255',
            'coach'         =>  'nullable|string|max:255',
            'avatar'        =>  'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'city'          =>  'nullable|string|max:255',
            'locationId'    =>  'nullable|integer|exists:locations,id',
        ];
    }
}
