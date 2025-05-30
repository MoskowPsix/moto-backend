<?php

namespace App\Http\Requests\Track;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property array $images
 * @property integer $levelId
 * @property string $desc
 * @property integer $length
 * @property integer $turns
 * @property bool $free
 * @property bool $is_work
 * @property array $spec
 * @property object $contacts
 * @property int $locationId
 * @property mixed offerFile
 */
class CreateTrackRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'              => 'string|required|min:3',
            'address'           => 'string|required',
            'latitude'          => 'required|numeric|between:-87,89',
            'longitude'         => 'required|numeric|between:-180,180',
            'images'            => 'array|nullable',
            'images.*'          => 'image|mimes:jpeg,png,jpg,svg,webp',
            'levelId'           => 'integer|requires|exists:levels,id',
            'desc'              => 'string|nullable',
            'length'            => 'integer|nullable',
            'turns'             => 'integer|nullable',
            'free'              => 'boolean|nullable',
            'is_work'           => 'boolean|required',
            'contacts'          => 'array|nullable',
            'spec'              => 'array|nullable',
            'locationId'        => 'integer|nullable|exists:locations,id',
            'logo'              => 'image|mimes:jpeg,png,jpg,svg,webp|nullable',
            'light'             => 'boolean|nullable',
            'season'            => 'boolean|nullable',
            'schemaImg'         => 'image|mimes:jpeg,png,jpg,svg,webp|nullable',
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
