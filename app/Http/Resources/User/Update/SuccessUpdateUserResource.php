<?php

namespace App\Http\Resources\User\Update;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessUpdateUserResource extends JsonResource
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
            'message'   => __('messages.user.update.success'),
            'user'      => UserResource::make($this->resource),
        ];
    }
}
