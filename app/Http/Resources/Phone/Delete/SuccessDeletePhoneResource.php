<?php

namespace App\Http\Resources\Phone\Delete;

use App\Http\Resources\Phone\PhoneResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessDeletePhoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'    => 'success',
            'message'   => __('messages.phone.delete.success'),
            'phone'     => PhoneResource::make($this->resource),
        ];
    }
}
