<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 */
class RegisterRequest extends FormRequest
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
                'required',
                'min:3',
                'max:50',
                Rule::unique('users'),
            ],
            'email'                  => [
                'required',
                'email',
            ],
            'password'               => 'required|min:8',
            'password_confirmation'  => 'required|same:password',
            'avatar'                 => 'nullable|image|mimes:jpeg,png,jpg,svg,webp'
        ];
    }
}
