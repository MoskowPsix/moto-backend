<?php

namespace App\Http\Resources\Document\GetForUser;

use App\Http\Resources\Document\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetDocumentForUserResource extends JsonResource
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
            'message' => __('messages.document.get_for_user.success'),
            'documents' => $this->resource instanceof Document ? DocumentResource::make($this->resource) : DocumentResource::collection($this->resource)
        ];
    }
}
