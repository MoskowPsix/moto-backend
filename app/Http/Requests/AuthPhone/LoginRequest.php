<?php

namespace App\Http\Requests\AuthPhone;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property bool $callback
 * @property int $number
 */
class LoginRequest extends FormRequest
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
            'number'    => 'required|string|min:10|max:12|exists:phones,number',
            'callback'  => 'nullable|boolean'
        ];
    }
}
