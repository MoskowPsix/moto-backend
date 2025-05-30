<?php

namespace App\Http\Requests\AppointmentRace;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $page
 * @property int $limit
 * @property bool $paginate
 */
class GetUsersAppointmentRaceRequest extends FormRequest
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
            'paginate'  => 'nullable|boolean',
            'page'      => 'nullable|string',
            'limit'     => 'nullable|integer|max:50',
        ];
    }
}
