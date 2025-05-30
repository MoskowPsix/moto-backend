<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $data
 */
class UpdateDocumentRequest extends FormRequest
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
            'file'                      => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'number'                    => 'nullable|string',
            'issuedWhom'                => 'nullable|string',
            'itWorksDate'               => 'nullable|string',
        ];
    }
}
