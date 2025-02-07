<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $file
 * @property string $type
 * @property array $data
 */
class CreateDocumentRequest extends FormRequest
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
            'type'                      => 'required|string',
            'file'                      => 'required|file|mimes:pdf,jpg,jpeg,png',
            'data'                      => 'required',
            'data.licensesNumber'       => 'nullable|string',
            'data.licensesFileLink'     => 'nullable|string',
            'data.polisNumber'          => 'nullable|string',
            'data.issuedWhom'           => 'nullable|string',
            'data.itWorksDate'          => 'nullable|date',
            'data.numberAndSeria'       => 'nullable|integer',
            'data.pasportFileLink'      => 'nullable|string',
            'data.polisFileLink'        => 'nullable|string',
        ];
    }
}
