<?php

namespace App\Http\Resources\Document\GetForUserById;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotFoundGetDocumentForUserByIdResource extends JsonResource
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
            'message' => __('messages.document.get_for_user_by_id.not_found'),
        ];
    }
    public function withResponse($request, $response): void
    {
        $response->setStatusCode(404);
    }
}
