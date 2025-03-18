<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $avatar
 * @property string $name
 * @property string $email
 */
class UpdateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'                   => [
                                            'nullable',
                                            'min:3',
                                            'max:50',
                                            Rule::unique('users'),
                                        ],
            'email'                  => [
                                            'nullable',
                                            'email',
                                            Rule::unique('users'),
                                        ],
            'avatar'                 => 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'number'                  => 'nullable|string|min:10|max:12|unique:phones,number',
        ];
    }
}
