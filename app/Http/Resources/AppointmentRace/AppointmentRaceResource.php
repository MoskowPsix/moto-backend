<?php

namespace App\Http\Resources\AppointmentRace;

use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'location'  => $this->whenLoaded('location', LocationResource::make($this->location)),
            'user'      => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
