<?php

namespace App\Http\Resources\AppointmentRace;

use App\Http\Resources\User\UserResource;
use App\Models\AppointmentRace;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetAppointmentRaceUsersForCommissionResource extends JsonResource
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
            'message'   => __('messages.appointment_race.get_users_for_commission.success'),
            'users'     => $this->resource,

        ];
    }
}
