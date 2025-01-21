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
            'name'              => 'required|string',
            'surname'           => 'required|string',
            'patronymic'        => 'required|string',
            'dateOfBirth'       => 'required|date',
            'city'              => 'required|string',
            'inn'               => 'required|integer',
            'snils'             => 'required|integer',
            'phoneNumber'       => 'required|string',
            'startNumber'       => 'required|integer',
            'group'             => 'required|string',
            'rank'              => 'required|string',
            'rankNumber'        => 'required|string',
            'community'         => 'nullable|string',
            'coach'             => 'nullable|string',
            'motoStamp'         => 'required|string',
            'engine'            => 'required|string',
        ];
    }
}
