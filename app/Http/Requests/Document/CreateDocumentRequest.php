<?php

namespace App\Http\Requests\Document;

use App\Enums\DocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $file
 * @property string $type
 * @property array $data
 * @property string $number
 * @property string $issuedWhom
 * @property string $itWorksDate
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
            'type'                      => ['required', Rule::enum(DocumentType::class)],
            'file'                      => 'required|file|mimes:pdf,jpg,jpeg,png',
            'url'                       => 'nullable|string',
            'number'                    => 'nullable|string',
            'issuedWhom'                => 'nullable|string',
            'itWorksDate'               => 'nullable|date',
        ];
    }
}
