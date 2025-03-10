<?php

namespace App\Http\Resources\AppointmentRace\Create;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeNotExistsAppointmentRaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'error',
            'message' => __('messages.appointment.create.grade_not_exists'),
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode(404);
    }
}
