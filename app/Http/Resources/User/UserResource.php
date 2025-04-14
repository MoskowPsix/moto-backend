<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Command\CommandResource;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\PersonalInfo\PersonalInfoResource;
use App\Http\Resources\Phone\PhoneResource;
use App\Http\Resources\Role\RoleResource;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property array $roles
 * @property string $email_verified_at
 * @property string $avatar
 * @property boolean $appointments_exists
 */
class UserResource extends JsonResource
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
            'email'                 => $this->email,
            'email_verified_at'     => $this->email_verified_at,
            'avatar'                => $this->avatar,
            'appointments_exists'   => $this->when(isset($this->appointments_exists), $this->appointments_exists),
            'roles'                 => RoleResource::collection($this->whenLoaded('roles')),
            'personal'              => PersonalInfoResource::make($this->whenLoaded('personalInfo')),
            'phone'                 => PhoneResource::make($this->whenLoaded('phone')),
            'documents'             => DocumentResource::collection($this->whenLoaded('documents')),
            'commands'              => CommandResource::make($this->whenLoaded('members')),
        ];
    }
}
