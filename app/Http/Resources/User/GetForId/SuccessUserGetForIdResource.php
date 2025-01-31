<?php

namespace App\Http\Resources\User\GetForId;

use App\Http\Resources\User\UserWithFIOResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessUserGetForIdResource extends JsonResource
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
            'message'   => __('messages.user.get_for_id.success'),
            'user'      => UserWithFIOResource::make($this->resource),
        ];
    }
}
