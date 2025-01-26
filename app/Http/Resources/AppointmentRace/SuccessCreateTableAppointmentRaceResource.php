<?php

namespace App\Http\Resources\AppointmentRace;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $url
 */
class SuccessCreateTableAppointmentRaceResource extends JsonResource
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
            'message'   => __('messages.appointment.create_table.success'),
            'table_url' => $this->resource ?? 'url'
        ];
    }
}
