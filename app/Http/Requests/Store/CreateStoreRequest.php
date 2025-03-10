<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $login
 * @property mixed $password_1
 * @property mixed $password_2
 * @property mixed $token
 */
class CreateStoreRequest extends FormRequest
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
            'login'         => 'required|string|max:255',
            'password_1'    => 'required|string|max:255',
            'password_2'    => 'required|string|max:255',
            'token'         => 'required|string|max:255',
        ];
    }
}
