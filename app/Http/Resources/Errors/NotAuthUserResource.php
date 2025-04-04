<?php

namespace App\Http\Resources\Errors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotAuthUserResource extends JsonResource
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
            'message' => __('messages.error.not_auth_user'),
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode(401);
    }
}
