<?php

namespace App\Http\Resources\Command\GetMembersForCoach;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithFIOResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetMembersForCoachCommandResource extends JsonResource
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
            'message' => __('messages.command.get_members_for_coach.success'),
            'members' => $this->resource instanceof User ? UserResource::make($this->resource) : UserResource::collection($this->resource),
        ];
    }
}
