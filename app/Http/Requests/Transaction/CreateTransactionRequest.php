<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property boolean    $status
 * @property string     $desc
 * @property integer    $count
 * @property integer    $userId
 * @property integer    $attendanceId
 * @property string     $date
 * @property array      $attendanceIds
 * @property bool       $isRace
 */
class CreateTransactionRequest extends FormRequest
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
            'attendanceIds'     => 'array|required',
            'attendanceIds.*'   => 'required|integer|exists:attendances,id',
            'isRace'            => 'nullable|boolean'
        ];
    }
}
