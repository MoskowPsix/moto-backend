<?php

namespace App\Http\Requests\RaceResult;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $userId
 * @property int $cupId
 * @property int $commandId
 * @property int $scores
 * @property int $place
 * @property int $gradeId
 */
class CreateRaceResultRequest extends FormRequest
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
            'userId'    => 'integer|required|exists:users,id',
            'cupId'     => 'integer|nullable|exists:cups,id',
            'commandId' => 'integer|nullable|exists:commands,id',
            'gradeId'   => 'integer|required|exists:grades,id',
            'scores'    => 'integer|required',
            'place'     => 'required|integer'
        ];
    }
}
