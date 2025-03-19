<?php

namespace App\Http\Resources\Command\GetMember;

use App\Http\Resources\User\UserWithFIOResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetMemberCommandResource extends JsonResource
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
            'message' => __('messages.couches.get.success'),
            'members' => $this->resource instanceof User ? UserWithFIOResource::make($this->resource) : UserWithFIOResource::collection($this->resource),
        ];
    }
}
