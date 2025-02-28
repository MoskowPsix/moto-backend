<?php

namespace App\Http\Requests\Command;

use Illuminate\Foundation\Http\FormRequest;

class GetForIdCommandRequest extends FormRequest
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
            'userId'        => 'nullable|integer',
            'locationId'    => 'nullable|integer',
            'city'          => 'nullable|string',
            'fullname'      => 'nullable|string',
            'coach'         => 'nullable|string',
        ];
    }
}
