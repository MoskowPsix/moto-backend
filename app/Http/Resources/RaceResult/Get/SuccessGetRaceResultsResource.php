<?php

namespace App\Http\Resources\RaceResult\Get;

use App\Http\Resources\Race\RaceResource;
use App\Http\Resources\RaceResult\RaceResultsResource;
use App\Models\RaceResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetRaceResultsResource extends JsonResource
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
            'message' => __('messages.result_race.get.success'),
            'race_results' => $this->resource instanceof RaceResult ? RaceResultsResource::make($this->resource) : RaceResultsResource::collection($this->resource),
        ];
    }
}
