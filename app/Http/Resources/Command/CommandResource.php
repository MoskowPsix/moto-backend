<?php

namespace App\Http\Resources\Command;

use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $fullName
 * @property string $coach
 * @property string $avatar
 * @property string $city
 * @property int $user
 * @property int $location
 * @property string $full_name
 */

class CommandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'full_name'  => $this->full_name,
            'coach'     => $this->coach,
            'city'      => $this->city,
            'avatar'    => $this->avatar,
            'user'      => UserResource::make($this->whenLoaded('user')),
            'location'  => LocationResource::make($this->whenLoaded('location')),
        ];
    }
}
