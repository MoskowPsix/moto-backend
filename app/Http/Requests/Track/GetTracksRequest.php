<?php

namespace App\Http\Requests\Track;

use Illuminate\Foundation\Http\FormRequest;

class GetTracksRequest extends FormRequest
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
            'userId'        => 'nullable|integer|exists:users,id',
            'storeIdExists' => 'nullable|integer|exists:stores,id',
            'checkStore'    => 'nullable|boolean',
            'paginate'      => 'nullable|boolean',
            'storeIdExists' => 'nullable|integer|exists:stores,id',
            'checkStore'    => 'nullable|boolean',
            'page'          => 'nullable|string',
            'limit'         => 'nullable|integer|max:50',
            'locationId'    => 'nullable|integer|exists:locations,id',
            'name'          => 'nullable|string'
        ];
    }
}
