<?php

namespace App\Http\Requests\AppointmentRace;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $data
 * @property mixed $gradeId
 */
class ToogleAppointmentRaceRequest extends FormRequest
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
            'surname'                  => 'required|string',
            'patronymic'               => 'required|string',
            'dateOfBirth'              => 'required|date',
            'city'                     => 'required|string',
            'region'                   => 'nullable|string',
            'inn'                      => 'required|string',
            'snils'                    => 'required|string',
            'phoneNumber'              => 'required|string',
            'startNumber'              => 'required|integer|min:1|max:999',
            'group'                    => 'required|string',
            'rank'                     => 'required|string',
            'rankNumber'               => 'nullable|string',
            'community'                => 'nullable|string',
            'coach'                    => 'nullable|string',
            'motoStamp'                => 'required|string',
            'locationId'               => 'required|exists:locations,id',
            'gradeId'                  => 'required|exists:grades,id',
            'commandId'                => 'nullable|exists:commands,id',
            'numberAndSeria'           => 'required|string',
            'documentIds'              => 'nullable|array',
            'documentIds.*'            => 'nullable|integer',
            'userId'                   => 'nullable|integer|exists:users,id',
            'transactionId'           => 'nullable|integer|exists:transactions,id'
        ];
    }
}
