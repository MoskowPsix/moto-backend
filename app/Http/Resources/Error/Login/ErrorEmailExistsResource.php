<?php

namespace App\Http\Resources\Error\Login;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorEmailExistsResource extends JsonResource
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
           'message' => __('messages.auth.login.email_exists')
        ];
    }
    public function withResponse($request, $response): void
    {
        $response->setStatusCode(422);
    }
}
