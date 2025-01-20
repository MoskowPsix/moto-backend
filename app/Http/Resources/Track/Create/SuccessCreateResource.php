<?php

namespace App\Http\Resources\Track\Create;

use App\Http\Resources\Track\TrackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessCreateResource extends JsonResource
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
            'message' => __('messages.track.create.success'),
            'track' => TrackResource::make($this->resource)
        ];
    }
}
