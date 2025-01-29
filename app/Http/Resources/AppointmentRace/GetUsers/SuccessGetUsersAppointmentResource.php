<?php

namespace App\Http\Resources\AppointmentRace\GetUsers;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithFIOResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetUsersAppointmentResource extends JsonResource
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
            'message'   => __('messages.appointment_race.get_users.success'),
            'users'     => $this->resource instanceof User ? UserWithFIOResource::make($this->resource) : UserWithFIOResource::collection($this->resource),
        ];
    }
}
