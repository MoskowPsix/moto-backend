<?php

namespace App\Http\Resources\Race\Update;

use App\Http\Resources\Race\RaceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessUpdateRaceResource extends JsonResource
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
            'message' => __('messages.race.update.success'),
            'race' => RaceResource::make($this->resource),
        ];
    }
}
