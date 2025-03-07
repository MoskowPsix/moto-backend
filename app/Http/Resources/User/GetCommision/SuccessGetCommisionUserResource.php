<?php

namespace App\Http\Resources\User\GetCommision;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithFIOResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetCommisionUserResource extends JsonResource
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
            'message' => __('messages.user.commision_get.success'),
            'users' => $this->resource instanceof User ? UserWithFIOResource::make($this->resource) : UserWithFIOResource::collection($this->resource)
        ];
    }
}
