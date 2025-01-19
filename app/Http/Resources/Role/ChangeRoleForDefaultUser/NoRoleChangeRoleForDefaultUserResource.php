<?php

namespace App\Http\Resources\Role\ChangeRoleForDefaultUser;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoRoleChangeRoleForDefaultUserResource extends JsonResource
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
            'message' => __('messages.role.get_change_role.no_role'),
        ];
    }
    public function withResponse($request, $response): void
    {
        $response->setStatusCode(403);
    }
}
