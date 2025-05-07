<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 * @property mixed $desc
 * @property mixed $price
 * @property mixed $tax
 * @property mixed $usn_income_outcome
 * @property mixed $trackId
 */
class CreateAttendanceRequest extends FormRequest
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
            'name'                  => 'required|string|max:255',
            'desc'                  => 'required|string|max:255',
            'price'                 => 'required|numeric',
            'tax'                   => 'required|string|max:255',
            'usn_income_outcome'    => 'required|string|max:255',
            'trackId'               => 'required|integer|exists:tracks,id',
        ];
    }
}
