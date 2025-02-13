<?php

namespace App\Http\Resources\Location\LocationResource;

use App\Http\Resources\Location\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetLocationResource extends JsonResource
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
            'message' => __('messages.location.get_all.success'),
            'data' => $this->resource instanceof Location ? LocationResource::make($this->resource) : LocationResource::collection($this->resource),
        ];
    }
}
