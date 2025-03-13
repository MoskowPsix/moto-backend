<?php

namespace App\Http\Requests\AuthPhone;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $number
 * @property int    $pin
 */
class VerifyPhoneRequest extends FormRequest
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
            'pin'       => 'required|string|min:3|max:4',
            'number'    => 'required|string|min:10|max:12|exists:phones,number',
        ];
    }
}
