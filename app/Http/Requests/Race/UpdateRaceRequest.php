<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRaceRequest extends FormRequest
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
            'name'          => 'nullable|string|max:255|min:3',
            'desc'          => 'nullable|string',
            'dateStart'     => 'nullable|date',
            'trackId'       => 'nullable|integer|exists:tracks,id',
            'images'        => 'array|nullable',
            'images.*'      => 'image|mimes:jpeg,png,jpg,svg,webp',
            'positionFile'  => 'nullable|file|mimes:pdf',
            'resultsFile'   => 'nullable|file|mimes:pdf',
        ];
    }
}
