<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

class GetForIdRaceRequest extends FormRequest
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
            'userId'            => 'nullable|integer',
            'appointmentUser'   => 'nullable|boolean',
            'favouritesUser'    => 'nullable|boolean',
            'gradeIds'          => 'nullable|array',
            'gradeIds.*'        => 'nullable|integer|exists:grades,id',
        ];
    }
}
