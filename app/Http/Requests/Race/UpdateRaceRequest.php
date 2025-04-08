<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $locationId
 * @property int $trackId
 * @property array $gradeIds
 * @property array $cupIds
 * @property string $recordEnd
 * @property string $recordStart
 */
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
            'name'              => 'nullable|string|max:255|min:3',
            'desc'              => 'nullable|string',
            'dateStart'         => 'nullable|date',
            'recordEnd'         => 'nullable|date',
            'recordStart'       => 'nullable|date',
            'trackId'           => 'nullable|integer|exists:tracks,id',
            'imagesAdd'         => 'array|nullable',
            'imagesAdd.*'       => 'image|mimes:jpeg,png,jpg,svg,webp',
            'imagesDel'         => 'array|nullable',
            'imagesDel.*'       => 'string',
            'positionFile'      => 'nullable|file|mimes:pdf',
            'resultsFile'       => 'nullable|file|mimes:pdf',
            'gradeIds'          => 'nullable|array',
            'gradeIds.*'        => 'nullable|integer|exists:grades,id',
            'locationId'        => 'nullable|integer|exists:locations,id',
            'statusId'          => 'integer|nullable|exists:statuses,id',
            'cupIds'            => 'nullable|array',
            'cupIds.*'          => 'nullable|integer|exists:cups,id',
        ];
    }
}
