<?php

namespace App\Http\Requests\Track;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackRequest extends FormRequest
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
            'name'              => 'string|required|min:3',
            'address'           => 'string|required',
            'latitude'          => 'required|numeric|between:-87,89',
            'longitude'         => 'required|numeric|between:-180,180',
            'imagesAdd'         => 'array|nullable',
            'imagesAdd.*'       => 'image|mimes:jpeg,png,jpg,svg,webp',
            'imagesDel'         => 'array|nullable',
            'imagesDel.*'       => 'string',
            'levelId'           => 'integer|nullable|exists:levels,id',
            'desc'              => 'string|nullable',
            'length'            => 'integer|nullable',
            'turns'             => 'integer|nullable',
            'free'              => 'boolean|nullable',
            'is_work'           => 'boolean|required',
            'contacts'          => 'nullable',
            'spec'              => 'nullable',
            'locationId'        => 'integer|nullable|exists:locations,id',
            'userId'            => 'integer|nullable|exists:users,id',
            'storeId'           =>  'integer|nullable|exists:stores,id',
            'offerFile'         => 'nullable|file|mimes:doc,docx,pdf',
            'requisitesName'    => 'nullable|string|max:255',
            'requisitesEmail'   => 'nullable|string|max:255',
            'requisitesPhone'   => 'nullable|string|max:255',
            'requisitesINN'     => 'nullable|string|max:255',
            'requisitesPricePolitics' => 'nullable|string|max:255',
        ];
    }
}
