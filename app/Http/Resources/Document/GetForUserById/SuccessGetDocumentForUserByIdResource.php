<?php

namespace App\Http\Resources\Document\GetForUserById;

use App\Http\Resources\Document\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetDocumentForUserByIdResource extends JsonResource
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
            'message' => __('messages.document.get_for_user_by_id.success'),
            'document' => DocumentResource::make($this->resource)
        ];
    }
}
