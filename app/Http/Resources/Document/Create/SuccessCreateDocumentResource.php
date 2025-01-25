<?php

namespace App\Http\Resources\Document\Create;

use App\Http\Resources\Document\DocumentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessCreateDocumentResource extends JsonResource
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
            'message' => __('messages.document.create.success'),
            'document' => DocumentResource::make($this->resource),
        ];
    }
}
