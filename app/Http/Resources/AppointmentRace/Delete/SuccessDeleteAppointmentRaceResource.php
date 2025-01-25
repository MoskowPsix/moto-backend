<?php

namespace App\Http\Resources\AppointmentRace\Delete;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessDeleteAppointmentRaceResource extends JsonResource
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
            'message' => __('messages.appointment_race.delete.success'),
        ];
    }
}
