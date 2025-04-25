<?php

namespace App\Http\Resources\Cup\GetForRaceId;

use App\Http\Resources\Cup\CupResource;
use App\Models\Cup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetForRaceIdCupResource extends JsonResource
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
            'message' => __('messages.cup.get_for_race_id.success'),
            'cup' => $this->resource instanceof Cup ? CupResource::make($this->resource) : CupResource::collection($this->resource)
        ];
    }
}
