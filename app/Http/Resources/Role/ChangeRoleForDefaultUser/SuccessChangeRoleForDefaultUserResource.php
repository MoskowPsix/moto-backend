<?php

namespace App\Http\Resources\Role\ChangeRoleForDefaultUser;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessChangeRoleForDefaultUserResource extends JsonResource
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
            'message' => __('messages.role.change_role_for_default_user.success'),
            'user' => UserResource::make($this->resource),
        ];
    }
}
