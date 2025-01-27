<?php

namespace App\Http\Resources\User\Update;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorUpdateUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'    => 'success',
            'message'   => __('messages.user.update.error'),
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(500);
    }
}
