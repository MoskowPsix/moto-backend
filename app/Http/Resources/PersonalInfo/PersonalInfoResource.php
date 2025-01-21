<?php

namespace App\Http\Resources\PersonalInfo;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $dateOfBirth
 * @property string $city
 * @property int $inn
 * @property int $snils
 * @property int $phone_number
 * @property int $start_number
 * @property string $group
 * @property int $rank_number
 * @property string $rank
 * @property string $community
 * @property string $coach
 * @property int $moto_stamp
 * @property string $engine
 */
class PersonalInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'              => $this->name,
            'surname'           => $this->surname,
            'patronymic'        => $this->patronymic,
            'date_of_birth'     => $this->dateOfBirth,
            'city'              => $this->city,
            'inn'               => $this->inn,
            'snils'             => $this->snils,
            'phone_number'      => $this->phone_number,
            'start_number'      => $this->start_number,
            'group'             => $this->group,
            'rank_number'       => $this->rank_number,
            'rank'              => $this->rank,
            'community'         => $this->community,
            'coach'             => $this->coach,
            'moto_stamp'        => $this->moto_stamp,
            'engine'            => $this->engine,
            'user'              => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
