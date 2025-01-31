<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $desc
 * @property string $date_start
 * @property array $images
 * @property int $trackId
 * @property string $dateStart
 * @property mixed $positionFile
 * @property mixed $resultsFile
 */
class CreateRaceRequest extends FormRequest
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
            'name'          => 'required|string|max:255|min:3',
            'desc'          => 'nullable|string',
            'dateStart'     => 'required|date',
            'trackId'       => 'required|integer|exists:tracks,id',
            'images'        => 'array|nullable',
            'images.*'      => 'image|mimes:jpeg,png,jpg,svg,webp',
            'positionFile'  => 'nullable|file|mimes:pdf',
            'resultsFile'   => 'nullable|file|mimes:pdf',
        ];
    }
}
