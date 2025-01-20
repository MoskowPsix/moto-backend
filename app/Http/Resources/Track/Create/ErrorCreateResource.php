<?php

namespace App\Http\Resources\Track\Create;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorCreateResource extends JsonResource
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
            'message' => __('messages.track.create.error'),
        ];
    }
    public function withResponse($request, $response): void
    {
        $response->setStatusCode(422);
    }
}
