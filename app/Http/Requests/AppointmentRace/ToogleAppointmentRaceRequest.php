<?php

namespace App\Http\Requests\AppointmentRace;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $data
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
            'data'                          => 'nullable|',
            'data.surname'                  => 'nullable|string',
            'data.patronymic'               => 'nullable|string',
            'data.dateOfBirth'              => 'nullable|timestamp',
            'data.city'                     => 'nullable|string',
            'data.region'                     => 'nullable|string',
            'data.inn'                      => 'nullable|integer',
            'data.snils'                    => 'nullable|integer',
            'data.phoneNumber'              => 'nullable|integer',
            'data.startNumber'              => 'nullable|integer|min:1|max:999',
            'data.group'                    => 'nullable|string',
            'data.rank'                     => 'nullable|string',
            'data.rankNumber'               => 'nullable|string',
            'data.community'                => 'nullable|string',
            'data.coach'                    => 'nullable|string',
            'data.motoStamp'                => 'nullable|string',
            'data.polisNumber'              => 'nullable|string',
            'data.issuedWhom'               => 'nullable|string',
            'data.itWorksDate'              => 'nullable|date',
            'data.polisFileLink'            => 'nullable|string',
            'data.licensesNumber'           => 'nullable|string',
            'data.licensesFileLink'         => 'nullable|string',
            'data.numberAndSeria'           => 'nullable|string',
            'data.pasportFileLink'          => 'nullable|string',

        ];
    }
}
