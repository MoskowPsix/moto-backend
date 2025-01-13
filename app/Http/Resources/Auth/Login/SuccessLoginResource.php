<?php

namespace App\Http\Resources\Auth\Login;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessLoginResource extends JsonResource
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
            'message'       => __('messages.auth.login.success'),
            'access_token'  => $this->resource->createToken('auth_token')->plainTextToken,
            'token_type'    => 'Bearer',
            'user'          => UserResource::make($this->resource)
        ];
    }
}
