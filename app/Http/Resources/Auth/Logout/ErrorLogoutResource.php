<?php

namespace App\Http\Resources\Auth\Logout;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorLogoutResource extends JsonResource
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
            'message'       => __('messages.auth.logout.error'),
        ];
    }
    public function withResponse($request, $response): void
    {
        $response->setStatusCode(403);
    }
}
