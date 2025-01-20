<?php

namespace App\Http\Requests\Track;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'string|required|min:3',
            'address'       => 'string|required',
            'latitude'      => 'required|numeric|between:-87,89',
            'longitude'     => 'required|numeric|between:-180,180',
            'images'        => 'array|nullable',
            'images.*'      => 'image|mimes:jpeg,png,jpg|max:2048',
            'levelId'       => 'integer|requires|exists:levels,id',
            'desc'          => 'string|nullable',
            'length'        => 'integer|nullable',
            'turns'         => 'integer|nullable',
            'free'          => 'boolean|nullable',
            'is_work'       => 'boolean|requires',
            'spec'          => 'json|nullable',
        ];
    }
}
