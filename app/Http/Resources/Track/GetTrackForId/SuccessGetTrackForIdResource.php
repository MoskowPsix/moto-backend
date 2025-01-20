<?php

namespace App\Http\Resources\Track\GetTrackForId;

use App\Http\Resources\Track\TrackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetTrackForIdResource extends JsonResource
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
            'message' => __('messages.track.get_for_id.success'),
            'track' => TrackResource::make($this->resource)
        ];
    }
}
