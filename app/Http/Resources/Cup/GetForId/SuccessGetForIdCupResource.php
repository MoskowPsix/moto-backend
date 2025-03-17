<?php

namespace App\Http\Resources\Cup\GetForId;

use App\Http\Resources\Cup\CupResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetForIdCupResource extends JsonResource
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
            'message' => __('messages.cup.get_for_id.success'),
            'cup' => CupResource::make($this->resource)
        ];
    }
}
