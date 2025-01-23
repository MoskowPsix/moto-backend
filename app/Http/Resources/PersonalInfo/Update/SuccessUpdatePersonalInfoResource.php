<?php

namespace App\Http\Resources\PersonalInfo\Update;

use App\Http\Resources\PersonalInfo\PersonalInfoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessUpdatePersonalInfoRequest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'        => 'success',
            'message'       => __('messages.personal_info.update.success'),
            'personal_info' => PersonalInfoResource::make($this->resource),
        ];
    }
}
