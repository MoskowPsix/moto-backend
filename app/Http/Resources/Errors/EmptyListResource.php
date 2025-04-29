<?php

namespace App\Http\Resources\Errors;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmptyListResource extends JsonResource
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
            'message'       => __('messages.error.empty_list'),
        ];
    }
    public function withResponse($request, $response)
    {
        $response->setStatusCode(404);
    }
}
