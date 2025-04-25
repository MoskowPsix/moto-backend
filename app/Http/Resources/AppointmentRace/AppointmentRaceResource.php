<?php

namespace App\Http\Resources\AppointmentRace;

use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property int $start_number
 * @property string $rank
 * @property string $coach
 */
class AppointmentRaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'surname'       => $this->surname,
            'name'          => $this->name,
            'patronymic'    => $this->patronymic,
            'rank'          => $this->rank,
            'city'          => $this->city,
            'coach'         => $this->coach,
            'start_number'  => $this->start_number,
//            'location'  => $this->whenLoaded('location', LocationResource::make($this->location)),
            'location'  => LocationResource::make($this->whenLoaded('location')),
            'user'      => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
