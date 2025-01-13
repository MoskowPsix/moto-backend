<?php

namespace App\Http\Resources\Auth\Register;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorRegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'        => 'error',
            'message'       => __('messages.auth.register.error'),
        ];
    }
    public function withResponse($request, $response): void
    {
        $response->setStatusCode(403);
    }
}
