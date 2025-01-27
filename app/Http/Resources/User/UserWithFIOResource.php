<?php

namespace App\Http\Resources\User;

use App\Http\Resources\PersonalInfo\PersonalInfoResource;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property object $personalInfo
 * @property string $avatar
 * @property string $name
 * @property int $id
 */
class UserWithFIOResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'avatar'                => $this->avatar,
            'personal'              => $this->when(isset($this->personalInfo), [
                'name' => $this->personalInfo->name,
                'surname' => $this->personalInfo->surname,
                'patronymic' => $this->personalInfo->patronymic,
                'city' => $this->personalInfo->city,
                'rank' => $this->personalInfo->rank,
                'start_number' => $this->personalInfo->start_number,
            ]),
        ];
    }
}
