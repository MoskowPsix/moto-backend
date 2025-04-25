<?php

namespace App\Http\Resources\District\Get;

use App\Http\Resources\District\DistrictResource;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetDistricsResource extends JsonResource
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
            'message'   => __('messages.district.get.success'),
            'districts' => $this->resource instanceof District ? DistrictResource::make($this->resource) : DistrictResource::collection($this->resource),
        ];
    }
}
