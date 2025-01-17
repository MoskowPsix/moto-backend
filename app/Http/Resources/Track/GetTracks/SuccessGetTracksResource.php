<?php

namespace App\Http\Resources\Track\GetTracks;

use App\Http\Resources\Track\TrackResource;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetTracksResource extends JsonResource
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
            'message' => __('messages.track.get.success'),
            'tracks' => $this->resource instanceof Track ? TrackResource::make($this->resource) : TrackResource::collection($this->resource)
        ];
    }
}
