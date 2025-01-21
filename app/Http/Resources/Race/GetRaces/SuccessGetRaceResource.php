<?php

namespace App\Http\Resources\Race\GetRaces;

use App\Http\Resources\Race\RaceResource;
use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetRaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'status'    => 'success',
            'message'   => __('messages.race.get.success'),
            'races'     => $this->resource instanceof Race ? RaceResource::make($this->resource) : RaceResource::collection($this->resource),
        ];
    }
}
