<?php

namespace App\Http\Resources\RaceResult;

use App\Http\Resources\Command\CommandResource;
use App\Http\Resources\Cup\CupResource;
use App\Http\Resources\Grade\GradeResource;
use App\Http\Resources\Race\RaceResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $place
 * @property int $scores
 */
class RaceResultsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'scores'    => $this->scores,
            'place'     => $this->place,
            'user'      => UserResource::make($this->whenLoaded('user')),
            'race'      => RaceResource::make($this->whenLoaded('race')),
            'cup'       => CupResource::make($this->whenLoaded('cup')),
            'command'   => CommandResource::make($this->whenLoaded('command')),
            'grade'     => GradeResource::make($this->whenLoaded('grade')),
        ];
    }
}
