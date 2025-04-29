<?php

namespace App\Http\Resources\RaceResult\Create;

use App\Http\Resources\RaceResult\RaceResultsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessCreateRaceResultResource extends JsonResource
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
            'message'   => __('messages.race_result.create.success'),
            'result'    => RaceResultsResource::make($this->resource),
        ];
    }
}
