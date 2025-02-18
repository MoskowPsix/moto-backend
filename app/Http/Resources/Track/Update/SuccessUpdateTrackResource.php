<?php

namespace App\Http\Resources\Track\Update;

use App\Http\Resources\Track\TrackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessUpdateTrackResource extends JsonResource
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
            'message' => __('messages.track.update.success'),
            'track' => TrackResource::make($this->resource),
        ];
    }
}
