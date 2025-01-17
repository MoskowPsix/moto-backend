<?php

namespace App\Http\Resources\Role\GetChangeRole;

use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetChangeRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'        => 'success',
            'message'       => __('messages.role.get_change_role.success'),
            'role'          => RoleResource::collection($this),
        ];
    }
}
