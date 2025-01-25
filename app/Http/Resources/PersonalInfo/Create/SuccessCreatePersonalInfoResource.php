<?php

namespace App\Http\Resources\PersonalInfo\Create;

use App\Http\Resources\PersonalInfo\PersonalInfoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessCreatePersonalInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'success',
            'message' => __('messages.personal_info.create.success'),
            'personal_info' => PersonalInfoResource::make($this->resource)
        ];
    }
}
