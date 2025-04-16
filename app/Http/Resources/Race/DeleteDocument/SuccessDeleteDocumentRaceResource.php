<?php

namespace App\Http\Resources\Race\DeleteDocument;

use App\Http\Resources\Race\RaceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessDeleteDocumentRaceResource extends JsonResource
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
            'message' => __('messages.race.documentDelete.success'),
            'race' => RaceResource::make($this->resource),
        ];
    }
}
