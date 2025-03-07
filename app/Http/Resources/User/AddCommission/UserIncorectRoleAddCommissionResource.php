<?php

namespace App\Http\Resources\User\AddCommission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserIncorectRoleAddCommissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'error',
           'message' => __('messages.user.add_commission.incorrect_role'),
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode(403);
    }
}
