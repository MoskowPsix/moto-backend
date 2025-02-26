<?php

namespace App\Http\Requests\PersonalInfo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $dateOfBirth
 * @property string $city
 * @property int $inn
 * @property int $snils
 * @property string $group
 * @property string $rank
 * @property string $community
 * @property string $coach
 * @property string $engine
 * @property int $phoneNumber
 * @property int $startNumber
 * @property int $rankNumber
 * @property string $motoStamp
 * @property int $numberAndSeria
 * @property string $region
 * @property int $locationId
 * @property int $commandId
 */
class CreatePersonalInfoRequest extends FormRequest
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
            'name'              => 'nullable|string',
            'surname'           => 'nullable|string',
            'patronymic'        => 'nullable|string',
            'dateOfBirth'       => 'nullable|date',
            'city'              => 'nullable|string',
            'inn'               => 'nullable|string',
            'snils'             => 'nullable|string',
            'phoneNumber'       => 'nullable|string',
            'startNumber'       => 'nullable|integer|min:1|max:999',
            'group'             => 'nullable|string',
            'rank'              => 'nullable|string',
            'rankNumber'        => 'nullable|string',
            'community'         => 'nullable|string',
            'coach'             => 'nullable|string',
            'motoStamp'         => 'nullable|string',
            'engine'            => 'nullable|string',
            'numberAndSeria'    => 'nullable|string',
            'region'            => 'nullable|string',
            'locationId'        => 'nullable|integer|exists:locations,id',
            'commandId'         => 'nullable|integer|exists:commands,id',
        ];
    }
}
