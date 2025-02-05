<?php

namespace App\Http\Resources\Race\ToggleIsWork;

use App\Http\Resources\Race\RaceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessToogleIsWorkRaceResource extends JsonResource
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
            'message' => __('messages.race.toggle_is_work.success', ['state' => $this->is_work ? 'рабочее' : 'не рабочее']),
            'race'   => RaceResource::make($this->resource),
        ];
    }
}
