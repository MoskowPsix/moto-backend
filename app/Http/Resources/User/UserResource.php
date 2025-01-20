<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $name
 * @property string $email
 * @property array $roles
 * @property string $email_verified_at
 * @property string $avatar
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
            'name'                  => $this->name,
            'email'                 => $this->email,
            'email_verified_at'     => $this->email_verified_at,
            'avatar'                => $this->avatar,
            'roles'                 => RoleResource::collection($this->whenLoaded('roles'))
        ];
    }
}
