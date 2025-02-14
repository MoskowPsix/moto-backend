<?php

namespace App\Http\Requests\PersonalInfo;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalInfoRequest extends FormRequest
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
            'name'              => 'nullable|string',
            'surname'           => 'nullable|string',
            'patronymic'        => 'nullable|string',
            'dateOfBirth'       => 'nullable|date',
            'city'              => 'nullable|string',
            'inn'               => 'nullable|string',
            'snils'             => 'nullable|string',
            'phoneNumber'       => 'nullable|string',
            'startNumber'       => 'nullable|integer',
            'group'             => 'nullable|string',
            'rank'              => 'nullable|string',
            'rankNumber'        => 'nullable|string',
            'community'         => 'nullable|string',
            'coach'             => 'nullable|string',
            'motoStamp'         => 'nullable|string',
            'engine'            => 'nullable|string',
            'numberAndSeria'    => 'nullable|integer',
            'region'            => 'nullable|string',
        ];
    }
}
