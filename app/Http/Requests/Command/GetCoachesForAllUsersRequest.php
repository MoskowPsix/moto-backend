<?php

namespace App\Http\Requests\Command;

use Illuminate\Foundation\Http\FormRequest;

class GetCoachesForAllUsersRequest extends FormRequest
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
            'paginate'          => 'nullable|boolean',
            'page'              => 'nullable|string',
            'limit'             => 'nullable|integer|max:50',
        ];
    }
}
