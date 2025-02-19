<?php

namespace App\Http\Resources\AppointmentRace\Create;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManyDocumentAppointmentRaceResource extends JsonResource
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
            'message' => __('messages.appointment.create_table.many_documents'),
            'documents' => $this->resource,
        ];
    }
}
