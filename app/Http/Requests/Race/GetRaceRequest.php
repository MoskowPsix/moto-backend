<?php

namespace App\Http\Requests\Race;

use App\Http\Resources\Race\RaceResource;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $page
 * @property int $limit
 * @property bool $paginate
 */
class GetRaceRequest extends FormRequest
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
            'userId'            => 'nullable|integer|exists:users,id',
            'paginate'          => 'nullable|boolean',
            'page'              => 'nullable|string',
            'limit'             => 'nullable|integer|max:50',
            'appointmentUser'   => 'nullable|boolean',
            'trackId'           => 'nullable|integer|exists:tracks,id',
            'pastRace'          => 'nullable|boolean',
            'gradeIds'          => 'nullable|array',
            'gradeIds.*'        => 'nullable|integer|exists:grades,id',
            'dateStart'         => 'nullable|date',
            'dateEnd'           => 'nullable|date',
            'locationIds'       => 'nullable|array',
            'locationIds.*'     => 'nullable|integer|exists:location,id'
        ];
    }
}
