<?php

namespace App\Http\Resources\User\GetUserForToken;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetUserForTokenResource extends JsonResource
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
            'message'   => __('messages.user.get_user_for_token.success'),
            'user'      => UserResource::make($this->resource)
        ];
    }
}
