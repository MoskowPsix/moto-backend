<?php

namespace App\Http\Requests\Cup;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 * @property mixed $year
 * @property mixed $locationId
 * @property mixed $userId
 * @property mixed $stages
 */
class CreateCupRequest extends FormRequest
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
            'name'          => 'required|string|max:255',
            'year'          => 'required|integer',
            'stages'        => 'nullable|string|max:255',
            'locationId'    => 'nullable|integer|exists:locations,id',
        ];
    }
}
